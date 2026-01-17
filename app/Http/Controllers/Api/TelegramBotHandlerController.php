<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\DownloadAndSendMp3Job;
use App\Jobs\YoutubeSearchJob;
use App\Models\Music;
use App\Models\User;
use App\Models\UserMessage;
use App\Services\TelegramBot\Contracts\iTelegramBotService;
use App\Services\YoutubeSearch\Contracts\iYoutubeSearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;

class TelegramBotHandlerController extends Controller
{
    protected $token;
    protected string $ytdlpPath;


    public function __construct()
    {
        $this->token = config("services.telegram.bot_token");
        $this->ytdlpPath = '/opt/homebrew/bin/yt-dlp';
    }

    public function webhook(Request $request, iTelegramBotService $telegram_service, iYoutubeSearchService $youtube_search_service)
    {
        $sendMessageUrl = "https://api.telegram.org/bot{$this->token}/sendMessage";


        // 1. ODDY XABARLAR (TEXT)
        if ($request->has("message")) {
            $message = $request->input('message.text');
            $chat_id = $request->input('message.chat.id');
            $userData = $request->input('message.from');
            $message_id = $request->input('message.message_id');

            // Foydalanuvchini bazaga yozish yoki yangilash
            if (!is_null($userData)) {
                $first_name = $userData['first_name'] ?? null;
                $last_name  = $userData['last_name'] ?? null;
                $fullname   = trim($first_name . ' ' . $last_name);

                User::updateOrCreate(
                    ['chat_id' => $userData['id']],
                    [
                        'is_bot'   => $userData['is_bot'],
                        'fullname' => $fullname,
                        'username' => $userData['username'] ?? null,
                        'status'   => 'active',
                        'registered_by' => 'telegram'
                    ]
                );
            }

            if ($message == '/start') {
                $locale_selected = User::where('chat_id', $chat_id)->value('locale') ?? 'uz';
                App::setLocale($locale_selected);
                $text = __("admin.start");

                // URL EMAS — local fayl yo'li (public ichidan)
                sendPhotoMessage(
                    $chat_id,
                    'AgACAgIAAxkBAAFA0a5pa2yQg42PW1nvRP1-i46L8zqIXAACrQ1rG3h1WEvYML6-0iHQ2AEAAwIAA3gAAzgE',
                    $text,
                    $this->token
                );


                return response()->json(['ok' => true]);
            }

            if ($message == '/lang') {
                $locale_selected = User::where('chat_id', $chat_id)->value('locale') ?? 'uz';
                $keyboard = buildLanguageKeyboard($locale_selected);
                sendStartWithButtons($chat_id, "O'zingizga qulay bo‘lgan tilni tanlang", $this->token, $keyboard);
                return response()->json(['ok' => true]);
            }

            $user = User::where('chat_id', $chat_id)->first();

            $user_message = UserMessage::create([
                'user_id' => $user->id,
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'message' => $message,
                'meta' => null,
            ]);



            if (isSocialMediaUrl($message)) {
                $telegram_service->sociolMedia($chat_id, $message_id, $message, $this->token);
                return;
            }
            // Qidiruv mantiqi
            $youtube_search_service->youtubeSearch($chat_id, $message);
        }

        // 2. CALLBACK QUERY (Tugmalar bosilganda)
        if ($request->has('callback_query')) {
            $callback = $request->input('callback_query');
            $chat_id     = $callback['message']['chat']['id'];
            $message_id  = $callback['message']['message_id'];
            $data        = $callback['data'];
            $callback_id = $callback['id'];

            // Paginatsiya: Oldingi/Keyingi
            if (str_starts_with($data, "page|")) {
                $stateKey = storage_path("app/ytsearch_{$chat_id}.json");
                if (!file_exists($stateKey)) {
                    answerTelegramCallback($callback_id, "Qidiruv muddati tugagan 😔", $this->token);
                    return response()->json(['ok' => true]);
                }

                $state = json_decode(file_get_contents($stateKey), true);
                $action = explode('|', $data)[1];

                if ($action === "next") $state['page']++;
                if ($action === "prev") $state['page']--;

                file_put_contents($stateKey, json_encode($state));
                $telegram_service->showSearchResults($chat_id, $state, $this->token, $message_id);
                // answerTelegramCallback($callback_id, "", $this->token);
            }

            // MP3 Yuklash
            if (str_starts_with($data, 'yt|')) {

                $videoId = explode('|', $data)[1];
                answerTelegramCallback($callback_id, "Yuklanmoqda, iltimos kuting...", $this->token);


                $loadingResp = Http::post("https://api.telegram.org/bot{$this->token}/sendSticker", [
                    'chat_id' => $chat_id,
                    'sticker' => 'CAACAgIAAxkBAAFA0aRpa2vWmXn4LAH4SqpWHtUD4opzDwACH4oAAnh1WEs-8AcZvvu0VDgE',
                ])->json();


                DownloadAndSendMp3Job::dispatch($chat_id, $videoId, $message_id, $loadingResp);
            }

            //         if (str_starts_with($data, 'acr|')) {

            //             [$action, $platform, $messageId] = explode('|', $data);

            //             $msg = UserMessage::where('chat_id', $chat_id)
            //                 ->where('message_id', $messageId)
            //                 ->first();

            //             if (!$msg) {
            //                 Log::warning('ACR: message topilmadi', compact('chat_id', 'messageId'));
            //                 return;
            //             }

            //             $url = $msg->message;
            //             Log::info("ACR ORIGINAL URL", ['url' => $url]);

            //             /* =========================
            //  * 1️⃣ VIDEO YUKLAB OLAMIZ
            //  * ========================= */
            //             $saveDir = storage_path('app/acr');
            //             if (!is_dir($saveDir)) {
            //                 mkdir($saveDir, 0755, true);
            //             }

            //             $videoFile = $saveDir . '/' . uniqid('video_') . '.mp4';

            //             $ytCmd = escapeshellcmd($this->ytdlpPath) . ' '
            //                 . '--no-playlist --no-warnings --quiet '
            //                 . '--merge-output-format mp4 '
            //                 . '-o ' . escapeshellarg($videoFile) . ' '
            //                 . escapeshellarg($url)
            //                 . ' 2>&1';

            //             exec($ytCmd, $ytOut, $ytStatus);

            //             if ($ytStatus !== 0 || !file_exists($videoFile)) {
            //                 Log::error('ACR YT-DLP FAIL', ['out' => $ytOut]);
            //                 return;
            //             }

            //             /* =========================
            //  * 2️⃣ 15 SEKUND AUDIO KESAMIZ
            //  * ========================= */
            //             $audioFile = $saveDir . '/' . uniqid('acr_') . '.mp3';

            //             $ffCmd = 'ffmpeg -y -ss 3 -i ' . escapeshellarg($videoFile)
            //                 . ' -t 12 -vn -ac 1 -ar 44100 -b:a 128k '
            //                 . escapeshellarg($audioFile)
            //                 . ' 2>&1';

            //             exec($ffCmd, $ffOut, $ffStatus);

            //             if ($ffStatus !== 0 || !file_exists($audioFile)) {
            //                 Log::error('ACR FFMPEG FAIL', ['out' => $ffOut]);
            //                 return;
            //             }

            //             /* =========================
            //  * 3️⃣ ACRCLOUD SIGNATURE
            //  * ========================= */
            //             $accessKey = config('services.acrcloud.access_key');
            //             $accessSecret = config('services.acrcloud.access_secret');
            //             $host = config('services.acrcloud.host');

            //             $httpMethod = 'POST';
            //             $httpUri = '/v1/identify';
            //             $dataType = 'audio';
            //             $signatureVersion = '1';
            //             $timestamp = time();

            //             $stringToSign = $httpMethod . "\n"
            //                 . $httpUri . "\n"
            //                 . $accessKey . "\n"
            //                 . $dataType . "\n"
            //                 . $signatureVersion . "\n"
            //                 . $timestamp;

            //             $signature = base64_encode(
            //                 hash_hmac('sha1', $stringToSign, $accessSecret, true)
            //             );

            //             /* =========================
            //  * 4️⃣ ACRCLOUD’GA YUBORAMIZ
            //  * ========================= */
            //             $acrRes = Http::timeout(25)
            //                 ->attach('sample', fopen($audioFile, 'r'), basename($audioFile))
            //                 ->post("https://{$host}/v1/identify", [
            //                     'access_key' => $accessKey,
            //                     'sample_bytes' => filesize($audioFile),
            //                     'timestamp' => $timestamp,
            //                     'signature' => $signature,
            //                     'data_type' => $dataType,
            //                     'signature_version' => $signatureVersion,
            //                 ]);

            //             $acrData = $acrRes->json();

            //             $music = $acrData['metadata']['music'][0] ?? null;

            //             $title  = trim($music['title'] ?? '');
            //             $artist = trim($music['artists'][0]['name'] ?? '');

            //             $query = trim($artist . ' ' . $title);

            //             $youtube_search_service->youtubeSearch($chat_id, $query);



            //             /* =========================
            //  * 5️⃣ NATIJANI LOG QILAMIZ
            //  * ========================= */
            //             Log::info('ACR RESPONSE', [
            //                 'status' => $acrRes->status(),
            //                 'body' => $acrData,
            //             ]);

            //             // ixtiyoriy: tozalash
            //             @unlink($videoFile);
            //             @unlink($audioFile);
            //         }



            // Tilni o'zgartirish
            if (in_array($data, ['uz', 'ru', 'en'])) {
                User::where('chat_id', $chat_id)->update(['locale' => $data]);
                answerTelegramCallback($callback_id, "Tayyor ✅", $this->token);
                $keyboard = buildLanguageKeyboard($data);
                sendStartWithButtons($chat_id, "Til o'zgardi", $this->token, $keyboard, $message_id);
            }

            if ($data === "clear") {
                $telegram_service->deleteMessage($chat_id, $message_id, $this->token);
            }
        }
        return response()->json(['ok' => true]);
    }
}
