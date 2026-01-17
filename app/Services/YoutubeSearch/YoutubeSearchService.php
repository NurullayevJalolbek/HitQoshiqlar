<?php

namespace App\Services\YoutubeSearch;

use App\Services\YoutubeSearch\Contracts\iYoutubeSearchService;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\TelegramBotHandlerController;
use App\Services\TelegramBot\Contracts\iTelegramBotService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class YoutubeSearchService implements iYoutubeSearchService
{

    protected $token;

    protected $youtube_key;

    protected $service;



    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->token = config("services.telegram.bot_token");
        $this->youtube_key = config("services.youtube.api_key");

        $this->service = app(iTelegramBotService::class);
    }


    public function youtubeSearch($chat_id, $message)
    {
        $startTime = microtime(true);

        $searchRes = Http::timeout(4)->get(
            'https://www.googleapis.com/youtube/v3/search',
            [
                'part' => 'id,snippet',
                'q' => trim($message) . ' audio',
                'type' => 'video',
                'videoCategoryId' => 10,
                'maxResults' => 30,
                'order' => 'relevance',
                'key' => $this->youtube_key,
            ]
        );

        $searchData = $searchRes->json();


        // Fail c2heck
        if (!$searchRes->ok() || empty($searchData['items'])) {
            Log::warning('YOUTUBE SEARCH FAIL', [
                'chat_id'    => $chat_id,
                'query'      => $message,
                'status'     => $searchRes->status(),
                'body_head'  => mb_substr($searchRes->body(), 0, 200),
            ]);

            sendMessage($chat_id, "⚠️ Ming afsus, musiqani topib bo'lmadi !", $this->token);
            return;
        }

        $results = collect($searchData['items'])
            ->map(function ($item) {
                $id = $item['id']['videoId'] ?? null;
                if (!$id) return null;

                return [
                    'id'       => $id,
                    'title'    => $item['snippet']['title'] ?? '',
                ];
            })
            ->filter()
            ->values()
            ->all();

        if (empty($results)) {
            sendMessage($chat_id, "⚠️ Ming afsus, musiqani topib bo'lmadi !", $this->token);
            return;
        }

        $executionTime = round(microtime(true) - $startTime, 3);

        $state = [
            'results'  => $results,
            'page'     => 0,
            'per_page' => 10,
        ];

        file_put_contents(
            storage_path("app/ytsearch_{$chat_id}.json"),
            json_encode($state, JSON_UNESCAPED_UNICODE)
        );

        $this->service->showSearchResults($chat_id, $state, $this->token);
    }
}
