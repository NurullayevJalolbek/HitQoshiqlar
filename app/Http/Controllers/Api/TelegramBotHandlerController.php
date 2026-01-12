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

                $query = addslashes($message);
                $ytdlpPath = '/opt/homebrew/bin/yt-dlp';

                $command = $ytdlpPath .
                    ' "ytsearch30:' . $query . '"' .
                    ' --skip-download' .
                    ' --no-warnings' .
                    ' --quiet' .
                    ' --flat-playlist' .
                    ' --print "%(id)s|%(title)s|%(duration)s" 2>&1';





                exec($command, $output);

                Log::warning("Youtubedan qaytgan qidiruv natijasi", [
                    "OUTPUT" => $output
                ]);


                session([
                    "yt_results_{$chat_id}" => $output
                ]);


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

                    // id|title|duration ni ajratamiz
                    $parts = explode("|", $row);

                    if (count($parts) < 2) continue;

                    $videoId = trim($parts[0]);
                    $title   = trim($parts[1]);
                    $seconds = isset($parts[2]) ? (int) floatval($parts[2]) : 0;

                    $duration = $seconds > 0 ? gmdate("i:s", $seconds) : "—";

                    // Matnga qo‘shamiz
                    $text .= $emojis[$i] . ". " . htmlspecialchars($title) . " <i>{$duration}</i>\n";

                    // Tugma
                    $buttons[] = [
                        'text' => $emojis[$i],
                        'callback_data' => "yt|" . $videoId
                    ];

                    // Video map (agar keyin ishlatsang)
                    $videoMap[$emojis[$i]] = $videoId;
                }


                // 2 qator 5 tadan qilish
                $keyboard = ['inline_keyboard' => []];
                $keyboard['inline_keyboard'][] = array_slice($buttons, 0, 5);
                $keyboard['inline_keyboard'][] = array_slice($buttons, 5, 5);

                // Navigation row
                $keyboard['inline_keyboard'][] = [
                    ['text' => '⬅️', 'callback_data' => 'page|prev'],
                    ['text' => '❌', 'callback_data' => 'clear'],
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
            $maxDisplay = 10;
            $totalResults = count($output);

            $text = "🎵 <b>Topilgan qo‘shiqlar:</b>\n\n";
            $buttons = [];
            $videoMap = [];

            foreach ($output as $i => $row) {
                if ($i >= $maxDisplay) break;

                $parts = explode("|", $row);
                if (count($parts) < 2) continue;

                $videoId = trim($parts[0]);
                $title   = trim($parts[1]);
                $seconds = isset($parts[2]) ? (int) floatval($parts[2]) : 0;
                $duration = $seconds > 0 ? gmdate("i:s", $seconds) : "—";

                $text .= $emojis[$i] . ". " . htmlspecialchars($title) . " <i>{$duration}</i>\n";

                $buttons[] = [
                    'text' => $emojis[$i],
                    'callback_data' => "yt|" . $videoId
                ];

                $videoMap[$emojis[$i]] = $videoId;
            }

            // 🔹 Sahifa raqamini matn oxiriga qo‘shamiz, faqat natija > 10 bo‘lsa
            if ($totalResults > $maxDisplay) {
                $totalPages = ceil($totalResults / $maxDisplay);
                $currentPage = 1; // default 1-chi sahifa
                $text .= "\n📄 $currentPage/$totalPages";
            }

            // 2 qator 5 tadan tugmalar
            $keyboard = ['inline_keyboard' => []];
            $keyboard['inline_keyboard'][] = array_slice($buttons, 0, 5);
            $keyboard['inline_keyboard'][] = array_slice($buttons, 5, 5);

            // Navigation row
            $navRow = [
                ['text' => '⬅️', 'callback_data' => 'page|prev'],
                ['text' => '❌', 'callback_data' => 'clear'],
                ['text' => '➡️', 'callback_data' => 'page|next'],
            ];

            // 🔹 Pagination tugmalarini faqat agar natija > 10 bo‘lsa qo‘shamiz
            if ($totalResults > $maxDisplay) {
                $keyboard['inline_keyboard'][] = $navRow;
            }

            sendStartWithButtons($chat_id, $text, $this->token, $keyboard);
        }

        return response()->json(['ok' => true]);
    }
}
