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
use App\Models\YoutubeSearchCache;
use App\Models\YoutubeSearchResult;
use Illuminate\Support\Facades\DB;


class YoutubeSearchService implements iYoutubeSearchService
{

    protected $token;

    protected $youtube_key;

    protected $service;
    protected  $groq_key;
    protected $gemini_key;



    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->token = config("services.telegram.bot_token");
        $this->youtube_key = config("services.youtube.api_key");

        $this->service = app(iTelegramBotService::class);
        $this->groq_key =  config("services.groq.groq_api_key");
        $this->gemini_key = config("services.gemini.gemini_api_key");
    }


    public function youtubeSearch($chat_id, $message)
    {
        $normalizedMessageQuery = $this->normalizeQuery($message);
        $keyNormalizedMessage   = sha1("q:$normalizedMessageQuery");

        $cache = DB::table('youtube_search_cache as c')
            ->join('youtube_search_results as r', 'r.query_id', '=', 'c.id')
            ->where('c.query_key', $keyNormalizedMessage)
            ->selectRaw('r.video_id, r.title, (1000 - r.position) as score')
            ->orderBy('r.position')
            ->get();


        if ($cache->isEmpty()) {
            $q = $normalizedMessageQuery;

            $cache = DB::table('youtube_search_results as r')
                ->selectRaw('r.video_id, max(r.title) as title, max(similarity(r.title, ?)) as score', [$q])
            ->where(function ($query) use ($q) {
                $query->where("r.title", "ILIKE", "%" . $q . "%")
                    ->orWhereRaw('similarity(r.title, ?) >= ?', [$q, 0.30]);
            })
            // ->whereRaw('similarity(r.title, ?) >= ?', [$q, 0.30])
                ->groupBy('r.video_id')
                ->orderByDesc('score')
                ->get();

        }


        if ($cache && $cache->count() > 5) {

            Log::info("DB Natijalari", [
                'cache' => $cache
            ]);

            $needle = $normalizedMessageQuery;

            $results = $cache
                ->sortByDesc('score')
                ->map(function ($r) use ($needle) {
                    $t = $r->title ?? '';

                    $rank = ($t === $needle) ? 0 : (str_contains($t, $needle) ? 1 : 2);

                    return [
                        'id'    => $r->video_id,
                        'title' => $t,
                        'rank'  => $rank,
                        'score' => $r->score ?? 0,
                    ];
                })
                ->sortBy(fn($x) => $x['rank'] * 100000 - $x['score'])
                ->map(fn($x) => [
                    'id'    => $x['id'],
                    'title' => $x['title'],
                ])
                ->values()
                ->all();
        } else {
            $youtubeQ = trim($normalizedMessageQuery) . ' audio';

            $searchRes = Http::timeout(4)->get(
                'https://www.googleapis.com/youtube/v3/search',
                [
                    'part'            => 'id,snippet',
                    'q'               => $youtubeQ,
                    'type'            => 'video',
                    'videoCategoryId' => 10,
                    'maxResults'      => 40,
                    'order'           => 'relevance',
                    'key'             => $this->youtube_key,
                ]
            );

            $searchData = $searchRes->json();

            if (!$searchRes->ok() || empty($searchData['items'])) {
                sendMessage($chat_id, "⚠️ Ming afsus, musiqani topib bo'lmadi !", $this->token);
                return;
            }

            $results = collect($searchData['items'])
                ->map(function ($item) {
                    $id = $item['id']['videoId'] ?? null;
                    if (!$id) return null;

                    return [
                        'id'    => $id,
                        'title' => $item['snippet']['title'] ?? '',
                    ];
                })
                ->filter()
                ->values()
                ->all();

            if (empty($results)) {
                sendMessage($chat_id, "⚠️ Ming afsus, musiqani topib bo'lmadi !", $this->token);
                return;
            }

            // ✅ 1) AVVAL userga yuboramiz
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

            // ✅ 2) KEYIN DB ga saqlaymiz
            $query = YoutubeSearchCache::updateOrCreate(
                ['query_key' => $keyNormalizedMessage],
                [
                    'query_text'       => $normalizedMessageQuery,
                    'clean_query'      => null,
                    'fetched_at'       => now(),
                    'last_hit_at'      => now(),
                ]
            );

            $query->increment('hit_count');

            YoutubeSearchResult::where('query_id', $query->id)->delete();

            foreach ($results as $i => $r) {
                $titleNorm = $this->normalizeQuery($r['title']);

                YoutubeSearchResult::updateOrCreate(
                    ['video_id' => $r['id']],
                    [
                        'query_id'  => $query->id,
                        'title'     => $titleNorm,
                        'position'  => $i,
                        'source'    => 'api',
                    ]
                );
            }

            return;
        }

        // 5) Userga ko‘rsatamiz
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



    private function normalizeQuery(string $q): string
    {
        $q = mb_strtolower($q, 'UTF-8');
        $q = str_replace(["’", "‘", "`", "´", "ʻ", "ʼ", "′"], "'", $q);
        $q = str_replace("'", "", $q);
        $q = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $q);
        $q = preg_replace('/\s+/u', ' ', $q);

        return trim($q);
    }


    private function groqParseQuery(string $message): ?string
    {
        if (empty($this->groq_key)) {
            Log::warning('GROQ: key missing');
            return null;
        }

        $system = <<<SYS
You are a professional music search intent analyzer. Your job is to extract the core Artist and Song Title from messy user requests.

### CRITICAL INSTRUCTIONS:
1. **IDENTIFY CORE SUBJECT**: Focus on the song title and artist. 
2. **DISCARD UNCERTAINTY**: Words like "adashmasam", "shekilli", "shunaqa shekilli", "boshqacha", "eski" are context fillers. DELETE THEM.
3. **STRIP FILLERS**: Remove all request verbs: "topib ber", "qidir", "menga", "yuklab ol", "ayt".
4. **LANGUAGE TAGS**: Remove "turkcha", "ruscha", "inglizcha", "-cha", "uz".
5. **TYPO CORRECTION & NORMALIZATION**:
   - "sen affetsen" -> "Bergen Sen Affetsen" (or "Sen Affetsen")
   - "the neybord" -> "The Neighbourhood"
   - "znayesh li ty" -> "Знаешь ли ты"
6. **IGNORE CONVERSATIONAL NOISE**: If a user says "adashmasam turkcha qo'shiq", the only thing that matters is the song name mentioned before or after it.

### EXAMPLES FOR YOUR GUIDANCE:
- "Sen affetsen qo'shig'ini topib ber adashmasam turkcha" -> {"clean_query": "Sen Affetsen"}
- "menga znayesh li ty ruschasini top" -> {"clean_query": "Знаешь ли ты"}
- "neybord softkor qidir" -> {"clean_query": "The Neighbourhood Softcore"}
- "shohruhxon qaysi qo'shig'i edi yangisi" -> {"clean_query": "Shohruhxon"}

### OUTPUT FORMAT:
Return ONLY strict JSON: {"clean_query": "..."}
SYS;


        $payloadBase = [
            'temperature' => 0.1, // Aniqlik uchun temperaturani pasaytirdik
            'messages' => [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user', 'content' => $message],
            ],
            'response_format' => ['type' => 'json_object'],
        ];

        $models = ['llama-3.1-8b-instant', 'llama-3.3-70b-versatile'];

        foreach ($models as $model) {
            try {
                $res = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->groq_key,
                    'Content-Type'  => 'application/json',
                ])->timeout(5)->post('https://api.groq.com/openai/v1/chat/completions', array_merge($payloadBase, [
                    'model' => $model,
                ]));

                if ($res->ok()) {
                    $data = $res->json('choices.0.message.content');
                    $parsed = json_decode($data, true);
                    return $parsed['clean_query'] ?? $parsed['cleanQuery'] ?? null;
                }
            } catch (\Exception $e) {
                Log::error('GROQ Error: ' . $e->getMessage());
                continue;
            }
        }

        return null;
    }
}
