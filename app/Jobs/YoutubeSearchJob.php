<?php

namespace App\Jobs;

use App\Http\Controllers\Api\TelegramBotHandlerController;
use App\Services\TelegramBot\Contracts\iTelegramBotService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class YoutubeSearchJob implements ShouldQueue
{
    use Queueable;

    public string $chat_id;

    public  string $message;
    protected $token;

    protected $youtube_key;


    /**
     * Create a new job instance.
     */
    public function __construct($chat_id, $message)
    {
        $this->chat_id =  $chat_id;
        $this->message = $message;
        $this->token = config("services.telegram.bot_token");
        $this->youtube_key = config("services.youtube.api_key");
    }


    public function handle(iTelegramBotService $service): void
    {
        $startTime = microtime(true);

        // 1) SEARCH: videoId + title
        $searchRes = Http::timeout(2)->get(
            'https://www.googleapis.com/youtube/v3/search',
            [
                'part' => 'snippet',
                'q' => $this->message,
                'type' => 'video',
                'maxResults' => 10,
                'key' => $this->youtube_key,
            ]
        );

        $searchData = $searchRes->json();

        if (!$searchRes->ok() || empty($searchData['items'])) {
            Log::warning('YOUTUBE SEARCH FAIL', [
                'chat_id' => $this->chat_id,
                'query'   => $this->message,
                'status'  => $searchRes->status(),
                'body_head' => mb_substr($searchRes->body(), 0, 200),
            ]);

            sendMessage($this->chat_id, "Ming afsus, hech narsa topilmadi 😔", $this->token);
            return;
        }

        // 2) Final results: id|title
        $results = [];
        foreach ($searchData['items'] as $item) {
            $id = $item['id']['videoId'] ?? null;
            if (!$id) continue;

            $results[] = [
                'id'    => $id,
                'title' => $item['snippet']['title'] ?? '',
            ];
        }

        if (empty($results)) {
            sendMessage($this->chat_id, "Ming afsus, hech narsa topilmadi 😔", $this->token);
            return;
        }

        $executionTime = round(microtime(true) - $startTime, 3);

        Log::info('YOUTUBE DATA API (SEARCH ONLY)', [
            'chat_id'       => $this->chat_id,
            'query'         => $this->message,
            'results_count' => count($results),
            'time_sec'      => $executionTime,
        ]);

        $state = [
            'results'  => $results,
            'page'     => 0,
            'per_page' => 10,
        ];

        file_put_contents(
            storage_path("app/ytsearch_{$this->chat_id}.json"),
            json_encode($state, JSON_UNESCAPED_UNICODE)
        );

        $service->showSearchResults($this->chat_id, $state, $this->token);
    }
}
