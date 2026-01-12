<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Music;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;

class TelegramBotHandlerController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->token = config("services.telegram.bot_token");
    }

    public function webhook(Request $request)
    {
        if ($request->has("message")) {
            $message = $request->input('message.text');
            $chat_id = $request->input('message.chat.id');
            $userData = $request->input('message.from');

            if (!is_null($userData)) {
                $first_name = $userData['first_name'] ?? null;
                $last_name  = $userData['last_name'] ?? null;
                $fullname   = trim($first_name . ' ' . $last_name);

                $user = User::updateOrCreate(
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

            Log::warning("Telegram webhook data", [
                'chat_id' => $chat_id,
                'message' => $message
            ]);

            // ===== /start va /language =====
            if ($message == '/start') {
                $locale_selected = User::where('chat_id', $chat_id)->value('locale') ?? 'uz';
                App::setLocale($locale_selected);

                $text = __("admin.start");
                sendMessage($chat_id, $text, $this->token);
            } else if ($message == '/lang') {
                $locale_selected = User::where('chat_id', $chat_id)->value('locale') ?? 'uz';
                $keyboard = buildLanguageKeyboard($locale_selected);
                $text = "O'zingizga qulay bo‘lgan tilni tanlang";
                sendStartWithButtons($chat_id, $text, $this->token, $keyboard);
            } else {

                $query = addslashes($message);
                $ytdlpPath = '/opt/homebrew/bin/yt-dlp';

                $command = escapeshellcmd($ytdlpPath) . ' ' .
                    escapeshellarg('ytsearch30:' . $query) .   // eng xavfsiz usul
                    ' --skip-download --flat-playlist --quiet --no-warnings' .
                    ' --print "%(id)s|%(title)s|%(duration_string)s" 2>&1';

                exec($command, $output);

                if (empty($output)) {
                    sendMessage($chat_id, "Ming afsus, siz izlagan qo‘shiq topilmadi 😔", $this->token);
                    return;
                }

                $emojis = ['1️⃣', '2️⃣', '3️⃣', '4️⃣', '5️⃣', '6️⃣', '7️⃣', '8️⃣', '9️⃣', '🔟'];

                $text = "🎵 <b>Topilgan qo‘shiqlar:</b>\n\n";

                $buttons = [];
                $videoMap = [];

                foreach ($output as $i => $row) {
                    if ($i > 9) break;

                    // Stringni ajratamiz
                    $parts = explode("|", $row);
                    if (count($parts) < 4) continue;

                    $videoId = $parts[0];
                    $title = $parts[1];
                    $durationSeconds = (int)$parts[3] ?? 0;
                    $duration = gmdate("i:s", $durationSeconds);

                    // Matn ko‘rinishi
                    $text .= $emojis[$i] . ". " . $title . " <i>" . $duration . "</i>\n";

                    // Tugma uchun
                    $buttons[] = [
                        'text' => $emojis[$i],
                        'callback_data' => "yt|" . $videoId
                    ];
                }

                // 2 qator 5 tadan
                $keyboard = ['inline_keyboard' => []];
                $keyboard['inline_keyboard'][] = array_slice($buttons, 0, 5);
                $keyboard['inline_keyboard'][] = array_slice($buttons, 5, 5);

                // Navigation
                $keyboard['inline_keyboard'][] = [
                    ['text' => '⬅️', 'callback_data' => 'page|prev'],
                    ['text' => '❌', 'callback_data' => 'clear'],
                    ['text' => '➡️', 'callback_data' => 'page|next'],
                ];


                // 2 qator 5 tadan qilish
                $keyboard = ['inline_keyboard' => []];
                $keyboard['inline_keyboard'][] = array_slice($buttons, 0, 5);
                $keyboard['inline_keyboard'][] = array_slice($buttons, 5, 5);

                // Navigation row
                $keyboard['inline_keyboard'][] = [
                    ['text' => '⬅️', 'callback_data' => 'page|prev'],
                    ['text' => '🗑', 'callback_data' => 'clear'],
                    ['text' => '➡️', 'callback_data' => 'page|next'],
                ];

                sendStartWithButtons($chat_id, $text, $this->token, $keyboard);
            }
        }

        if ($request->has('callback_query')) {
            $callback = $request->input('callback_query');
            $chat_id     = $callback['message']['chat']['id'];
            $message_id  = $callback['message']['message_id'];
            $selected    = $callback['data'];
            $callback_id = $callback['id'];

            // ===== Tilni yangilash =====
            if (in_array($selected, ['uz', 'ru', 'en'])) {

                User::where('chat_id', $chat_id)->update(['locale' => $selected]);
                App::setLocale($selected);

                Log::info("Set Locale", [
                    'locale' => $selected,
                ]);

                $langTexts = [
                    'uz' => ['title' => "Til muvaffaqiyatli yangilandi ✅", 'select' => "O‘zingizga qulay bo‘lgan tilni tanlang"],
                    'ru' => ['title' => "Язык успешно обновлён ✅", 'select' => "Выберите удобный для вас язык"],
                    'en' => ['title' => "Language successfully updated ✅", 'select' => "Choose the language you prefer"]
                ];



                answerTelegramCallback($callback_id, $langTexts[$selected]['title'], $this->token);
                $keyboard = buildLanguageKeyboard($selected);
                sendStartWithButtons($chat_id, $langTexts[$selected]['select'], $this->token, $keyboard, $message_id);
            }

            // ===== YouTube mp3 yuklash =====
            if (str_starts_with($selected, 'yt|')) {

                $videoId = explode('|', $selected)[1];
                $channelId = '-1003397606314';
                $telegramUrl = "https://api.telegram.org/bot{$this->token}/sendAudio";

                // 🔹 1️⃣ DB dan tekshirish
                $music = Music::where('yt_id', $videoId)->first();

                if ($music && $music->field_id) {
                    Http::post($telegramUrl, [
                        'chat_id' => $chat_id,
                        'audio' => $music->field_id,
                        'caption' => "\n@HitQoshiqlarBot"
                    ]);
                } else {
                    $videoUrl = "https://www.youtube.com/watch?v=" . $videoId;
                    $fileName = storage_path("app/public/audio_" . md5($videoId . time()) . ".mp3");
                    $ytdlpPath = '/opt/homebrew/bin/yt-dlp';

                    // Tez + sifatli + baribir MP3 (ko‘pchilik uchun eng maqbul)
                    $command = escapeshellcmd($ytdlpPath) . " " .
                        escapeshellarg($videoUrl) .
                        " -f bestaudio -x --audio-format mp3 --audio-quality 5" .
                        " --no-playlist --no-warnings --quiet" .
                        " -o " . escapeshellarg($fileName) .
                        " 2>&1";

                    exec($command, $output, $status);

                    Log::info("Bitta qo'shiq OUTPUT",[
                        "OUTPUT" => $output
                    ]);

                    $fileExists = file_exists($fileName);
                    $fileSize = $fileExists ? filesize($fileName) : 0;
                    $success = ($status === 0 && $fileExists && $fileSize > 50000);

                    if ($success) {
                        $title  = trim(shell_exec("$ytdlpPath --get-title " . escapeshellarg($videoUrl)));
                        $artist = trim(shell_exec("$ytdlpPath --get-uploader " . escapeshellarg($videoUrl)));

                        $safeTitle  = preg_replace('/[^a-zA-Z0-9 _\-]/u', '', $title);
                        $safeArtist = preg_replace('/[^a-zA-Z0-9 _\-]/u', '', $artist);
                        $tgFileName = trim($safeTitle . " - " . $safeArtist) . ".mp3";

                        // 🔹 3️⃣ Foydalanuvchiga yuborish
                        if ($fp = fopen($fileName, 'r')) {
                            // Foydalanuvchiga yuborish
                            $response = Http::timeout(180)
                                ->attach('audio', $fp, $tgFileName, ['Content-Type' => 'audio/mpeg'])
                                ->post($telegramUrl, [
                                    'chat_id' => $chat_id,
                                    'title' => mb_substr($title, 0, 64),
                                    'performer' => mb_substr($artist, 0, 64),
                                    'caption' => "\n@HitQoshiqlarBot"
                                ]);
                            fclose($fp);

                            // Kanalga yuborish va file_id olish
                            if ($fp2 = fopen($fileName, 'r')) {
                                $channelResponse = Http::timeout(180)
                                    ->attach('audio', $fp2, $tgFileName, ['Content-Type' => 'audio/mpeg'])
                                    ->post($telegramUrl, [
                                        'chat_id' => $channelId,
                                        'title' => mb_substr($title, 0, 64),
                                        'performer' => mb_substr($artist, 0, 64),
                                        'caption' => "\n@HitQoshiqlarBot"
                                    ]);
                                fclose($fp2);

                                $channelResult = $channelResponse->json();
                                $file_id = $channelResult['result']['audio']['file_id'] ?? null;

                                // DB ga saqlash
                                if ($file_id) {
                                    Music::create([
                                        'yt_id' => $videoId,
                                        'field_id' => $file_id
                                    ]);
                                }
                            }
                        } else {
                            sendMessage($chat_id, "❌ Fayl ochilmadi", $this->token);
                            answerTelegramCallback($callback_id, "❌ Xato", $this->token);
                        }
                    } else {
                        sendMessage($chat_id, "❌ Yuklab bo‘lmadi", $this->token);
                        answerTelegramCallback($callback_id, "❌ Xato", $this->token);
                    }

                    @unlink($fileName);
                }
            }
        }

        return response()->json(['ok' => true]);
    }
}
