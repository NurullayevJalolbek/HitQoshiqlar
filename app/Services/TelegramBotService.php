<?php

namespace App\Services;

use App\Services\Contracts\ITelegramBotService;
use Illuminate\Support\Facades\Http;



class TelegramBotService implements iTelegramBotService
{
    public function showSearchResults($chat_id, $state, $token,  $message_id = null): void
    {
        $page     = $state['page'];
        $per_page = $state['per_page'];
        $results  = $state['results'];
        $total    = count($results);
        $max_page = (int) ceil($total / $per_page) - 1;

        if ($page < 0) $page = 0;
        if ($page > $max_page) $page = $max_page;

        $start = $page * $per_page;
        $end   = min($start + $per_page, $total);
        $emojis = ['1️⃣', '2️⃣', '3️⃣', '4️⃣', '5️⃣', '6️⃣', '7️⃣', '8️⃣', '9️⃣', '🔟'];

        $text = "🎵 <b>Topilgan qo‘shiqlar:</b> sahifa " . ($page + 1) . "/" . ($max_page + 1) . "\n\n";
        $buttons = [];

        for ($i = $start; $i < $end; $i++) {
            $num = $i - $start;
            $text .= $emojis[$num] . ". " . htmlspecialchars($results[$i]['title']) . " [{$results[$i]['duration']}]\n";
            $buttons[] = [
                'text' => $emojis[$num],
                'callback_data' => "yt|{$results[$i]['id']}"
            ];
        }

        $keyboard = ['inline_keyboard' => []];
        $keyboard['inline_keyboard'][] = array_slice($buttons, 0, 5);
        if (count($buttons) > 5) {
            $keyboard['inline_keyboard'][] = array_slice($buttons, 5, 5);
        }

        $nav = [];
        if ($page > 0) $nav[] = ['text' => '⬅️', 'callback_data' => "page|prev"];
        $nav[] = ['text' => '❌', 'callback_data' => "clear"];
        if ($page < $max_page) $nav[] = ['text' => '➡️', 'callback_data' => "page|next"];

        $keyboard['inline_keyboard'][] = $nav;

        // Agar message_id bo'lsa edit qilamiz, bo'lmasa yangi yuboramiz
        sendStartWithButtons($chat_id, $text, $token, $keyboard, $message_id);
    }

    public function deleteMessage($chat_id, $message_id, $token)
    {
        $url = "https://api.telegram.org/bot{$token}/deleteMessage";

        $response = Http::post($url, [
            'chat_id'    => $chat_id,
            'message_id' => $message_id,
        ]);

        return $response->json();
    }
}
