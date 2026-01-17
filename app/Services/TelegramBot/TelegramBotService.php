<?php

namespace App\Services\TelegramBot;

use App\Jobs\InstagramDownloadJob;
use App\Jobs\TikTokDownloadJob;
use App\Services\TelegramBot\Contracts\iTelegramBotService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramBotService implements iTelegramBotService
{
    protected $ytdlpPath;
    public function __construct()
    {
        $this->ytdlpPath = '/opt/homebrew/bin/yt-dlp';
    }
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
        $numbers= ['1','2', '3', '4','5','6','7','8','9','10'];


        $text = "\n";
        $buttons = [];

        for ($i = $start; $i < $end; $i++) {
            $num = $i - $start;
            $text .= $emojis[$num] . ". " . htmlspecialchars($results[$i]['title']. "\n");
            $buttons[] = [
                'text' => $numbers[$num],
                'callback_data' => "yt|{$results[$i]['id']}"
            ];
        }

        $keyboard = ['inline_keyboard' => []];
        $keyboard['inline_keyboard'][] = array_slice($buttons, 0, 5);
        if (count($buttons) > 5) {
            $keyboard['inline_keyboard'][] = array_slice($buttons, 5, 5);
        }

        $nav = [];
        if ($page > 0) $nav[] = ['text' => '《', 'callback_data' => "page|prev"];
        $nav[] = ['text' => '❌', 'callback_data' => "clear"];
        if ($page < $max_page) $nav[] = ['text' => '》', 'callback_data' => "page|next"];

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

    public function sociolMedia($chat_id, $message_id, $url, $token)
    {
        $host = parse_url($url, PHP_URL_HOST);
        $host = strtolower($host);

        Log::info('URL HOST', ['host' => $host]);

        // PLATFORM ANIQLASH
        if (isInstagram($host)) {
            InstagramDownloadJob::dispatch($chat_id, $message_id, $url);
        } elseif (isYoutube($host)) {
            Log::info('Bu YouTube', ['url' => $url]);
        } elseif (isTikTok($host)) {
            TikTokDownloadJob::dispatch($chat_id, $message_id, $url);
        } elseif (isFacebook($host)) {
            Log::info('Bu Facebook', ['url' => $url]);
        } elseif (isSnapchat($host)) {
            Log::info('Bu Snapchat', ['url' => $url]);
        } elseif (isLikee($host)) {
            Log::info('Bu Likee', ['url' => $url]);
        } else {
            Log::warning('Nomaʼlum ijtimoiy tarmoq', [
                'host' => $host,
                'url'  => $url
            ]);
        }
    }
}
