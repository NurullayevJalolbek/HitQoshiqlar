<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
                // ===== Beta qo‘shiq qidiruv =====
                $response = Http::get("https://api.deezer.com/search", [
                    'q' => $message,
                    'limit' => 10
                ]);

                $tracks = $response->json()['data'] ?? [];

                Log::warning("Deezerdan topilgan qo'shiqlar", [
                    "tracks" => $tracks,
                ]);


                if (empty($tracks)) {
                    $locale = User::where('chat_id', $chat_id)->value('locale') ?? 'uz';
                    App::setLocale($locale);


                    $not_found  = __('admin.not_found');
                    sendMessage($chat_id, $not_found . "😔", $this->token);
                } else {
                    $keyboard = ['inline_keyboard' => []];

                    foreach ($tracks as $track) {
                        $keyboard['inline_keyboard'][] = [
                            [
                                'text' => $track['title'] . " - " . $track['artist']['name'],
                                'callback_data' => "yt|" . $track['title'] . "|" . $track['artist']['name']
                            ]
                        ];
                    }

                    sendStartWithButtons($chat_id, "Topilgan qo‘shiqlar:", $this->token, $keyboard);
                }
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
                [$prefix, $title, $artist] = explode('|', $selected);
                $searchQuery = "$title $artist"; // yt-dlp qidiruv so‘rovi

                Log::info("=== QO'SHIQ YUKLASH ===", [
                    'title' => $title,
                    'artist' => $artist
                ]);

                // ===== 1. Fayl nomi va yt-dlp yo‘li =====
                $fileName = storage_path("app/public/audio_" . md5($title . $artist . time()) . ".mp3");
                $ytdlpPath = '/opt/homebrew/bin/yt-dlp'; // MacOS misol, serverga mos o‘zgartiring

                // ===== 2. yt-dlp komandasi =====
                $command = escapeshellcmd($ytdlpPath) .
                    " \"ytsearch1:" . escapeshellarg($searchQuery) . "\"" .
                    " -x --audio-format mp3 --audio-quality 320k" .
                    " --output " . escapeshellarg($fileName) .
                    " 2>&1";

                Log::info("yt-dlp komandasi", ['command' => $command, 'file' => $fileName]);

                // ===== 3. Ishga tushirish =====
                set_time_limit(240); // 4 daqiqa
                exec($command, $output, $status);

                $fileExists = file_exists($fileName);
                $fileSize = $fileExists ? filesize($fileName) : 0;
                $success = ($status === 0 && $fileExists && $fileSize > 50000); // 50KB dan katta bo‘lsa

                Log::info("yt-dlp natijasi", [
                    'status' => $status,
                    'file_exists' => $fileExists,
                    'file_size' => $fileSize,
                    'success' => $success,
                    'output_sample' => implode("\n", array_slice($output, -5))
                ]);

                // ===== 4. Telegramga yuborish =====
                if ($success) {
                    try {
                        $telegramUrl = "https://api.telegram.org/bot{$this->token}/sendAudio";

                        $response = Http::timeout(120)
                            ->attach('audio', fopen($fileName, 'r'), 'song.mp3', [
                                'Content-Type' => 'audio/mpeg'
                            ])
                            ->post($telegramUrl, [
                                'chat_id' => $chat_id,
                                'title' => mb_substr($title, 0, 64),
                                'performer' => mb_substr($artist, 0, 64),
                                'caption' => "🎵 $title\n🎤 $artist\n\n@HitQoshiqlarBot"
                            ]);

                        if ($response->successful()) {
                            answerTelegramCallback($callback_id, "✅ Qo'shiq yuborildi!", $this->token);
                            Log::info("Telegramga muvaffaqiyatli yuklandi");
                        } else {
                            $error = $response->json();
                            sendMessage($chat_id, "❌ Telegram API xatosi", $this->token);
                            Log::error("Telegram API error", ['error' => $error]);
                        }
                    } catch (\Exception $e) {
                        sendMessage($chat_id, "❌ Yuklashda xato: " . $e->getMessage(), $this->token);
                        Log::error("Exception", [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }

                    // Faylni tozalash
                    @unlink($fileName);
                } else {
                    // Xato xabari
                    $errorMsg = "❌ MP3 yuklashda xato\n";
                    $errorMsg .= "Status: $status\n";
                    $errorMsg .= "Fayl: " . ($fileExists ? "mavjud" : "yo'q") . "\n";

                    if ($fileExists) {
                        $errorMsg .= "Hajm: " . round($fileSize / 1024) . " KB\n";
                    }

                    if (!empty($output)) {
                        $lastLines = array_slice($output, -5);
                        $errorMsg .= "Xato: " . implode("; ", $lastLines);
                    }

                    sendMessage($chat_id, $errorMsg, $this->token);

                    if ($fileExists) {
                        @unlink($fileName);
                    }
                }

                // Callback javobi
                answerTelegramCallback($callback_id, $success ? "✅ Qo'shiq yuborildi!" : "❌ Xato yuz berdi", $this->token);
            }
        }

        return response()->json(['ok' => true]);
    }
}
