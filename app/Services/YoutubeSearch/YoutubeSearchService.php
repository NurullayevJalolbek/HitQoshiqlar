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

        // 1) SEARCH: videoId + title
        $searchRes = Http::timeout(2)->get(
            'https://www.googleapis.com/youtube/v3/search',
            [
                'part' => 'snippet',
                'q' => $message,
                'type' => 'video',
                'maxResults' => 30,
                'key' => $this->youtube_key, 
            ]
        );

        $searchData = $searchRes->json();

        if (!$searchRes->ok() || empty($searchData['items'])) {
            Log::warning('YOUTUBE SEARCH FAIL', [
                'chat_id' => $chat_id,
                'query' => $message,
                'status' => $searchRes->status(),
                'body_head' => mb_substr($searchRes->body(), 0, 200),
            ]);

            sendMessage($chat_id, "Ming afsus, hech narsa topilmadi 😔", $this->token);
            return;
        }

        $videoIds = collect($searchData['items'])
            ->pluck('id.videoId')
            ->filter()
            ->values()
            ->implode(',');

        // 2) VIDEOS: duration (ISO 8601)
        $videosRes = Http::timeout(2)->get(
            'https://www.googleapis.com/youtube/v3/videos',
            [
                'part' => 'contentDetails',
                'id' => $videoIds,
                'key' => $this->youtube_key,
            ]
        );

        $videosData = $videosRes->json();

        // ISO 8601 -> seconds
        $isoToSeconds = function (?string $iso): int {
            if (!$iso) return 0;
            preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/', $iso, $m);
            $h = isset($m[1]) ? (int)$m[1] : 0;
            $min = isset($m[2]) ? (int)$m[2] : 0;
            $s = isset($m[3]) ? (int)$m[3] : 0;
            return $h * 3600 + $min * 60 + $s;
        };

        $durationMap = collect($videosData['items'] ?? [])->mapWithKeys(function ($v) use ($isoToSeconds) {
            $id = $v['id'] ?? null;
            $iso = $v['contentDetails']['duration'] ?? null;
            return $id ? [$id => $isoToSeconds($iso)] : [];
        });

        // 3) Final results: id|title|duration(seconds)
        $results = [];
        foreach ($searchData['items'] as $item) {
            $id = $item['id']['videoId'] ?? null;
            if (!$id) continue;

            $results[] = [
                'id'       => $id,
                'title'    => $item['snippet']['title'] ?? '',
                'duration' => (string)($durationMap[$id] ?? 0),
            ];
        }

        if (empty($results)) {
            sendMessage($chat_id, "Ming afsus, hech narsa topilmadi 😔", $this->token);
            return;
        }

        $executionTime = round(microtime(true) - $startTime, 3);

        Log::info('YOUTUBE DATA API', [
            'chat_id' => $chat_id,
            'query' => $message,
            'results_count' => count($results),
            'time_sec' => $executionTime,
        ]);

        $state = [
            'results'  => $results,
            'page'     => 0,
            'per_page' => 10
        ];

        file_put_contents(
            storage_path("app/ytsearch_{$chat_id}.json"),
            json_encode($state, JSON_UNESCAPED_UNICODE)
        );

        $this->service->showSearchResults($chat_id, $state, $this->token);
    }
}
