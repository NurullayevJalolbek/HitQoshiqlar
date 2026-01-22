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

        $sendAudioUrl = "https://api.telegram.org/bot{$this->token}/sendAudio";


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

             UserMessage::create([
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
            // Qidiruv mantiqi,  User yozgan qoshiqni qidirish  
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
            }

            // MP3 Yuklash
            if (str_starts_with($data, 'yt|')) {

                $videoId = explode('|', $data)[1];

                $loadingResp =  sendCachedMusicOrLoading($chat_id,$message_id, $videoId, $sendAudioUrl, $this->token);
                if ($loadingResp == false) return;


                answerTelegramCallback($callback_id, "Yuklanmoqda, iltimos kuting...", $this->token);
                DownloadAndSendMp3Job::dispatch($chat_id, $videoId, $message_id, $loadingResp);
                return;
            }
            //Videoni audiosini yuklash
            if (str_starts_with($data, "acr|youtube|")) {

                $videoId = explode('|', $data)[2];

                $loadingResp =  sendCachedMusicOrLoading($chat_id, $message_id, $videoId, $sendAudioUrl, $this->token);

                if ($loadingResp == false) return;

                answerTelegramCallback($callback_id, "Yuklanmoqda, iltimos kuting...", $this->token);
                DownloadAndSendMp3Job::dispatch($chat_id, $videoId, $message_id, $loadingResp);
                return;
            }

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
