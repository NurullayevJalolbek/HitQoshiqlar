<?php

namespace App\Jobs;

use App\Http\Controllers\Api\TelegramBotHandlerController;
use App\Services\Contracts\iTelegramBotService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;


class YoutubeSearchJob implements ShouldQueue
{
    use Queueable;

    public string $chat_id;

    public  string $message;
    protected $token;



    /**
     * Create a new job instance.
     */
    public function __construct($chat_id, $message)
    {
        $this->chat_id =  $chat_id;
        $this->message = $message;
        $this->token = config("services.telegram.bot_token");
    }

    /**
     * Execute the job.
     */
    public function handle(iTelegramBotService $service): void
    {
        $query = addslashes($this->message);
        $ytdlpPath = '/opt/homebrew/bin/yt-dlp';

        $command = $ytdlpPath .
            ' "ytsearch30:' . $query . '"' .
            ' --skip-download' .
            ' --no-warnings' .
            ' --quiet' .
            ' --flat-playlist' .
            ' --print "%(id)s|%(title)s|%(duration)s" 2>&1';


        exec($command, $output);

        if (empty($output)) {
            sendMessage($this->chat_id, "Ming afsus, hech narsa topilmadi 😔", $this->token);
            return;
        }


        $results = [];
        foreach ($output as $row) {
            $parts = explode("|", $row);
            if (count($parts) < 3) continue;
            $results[] = [
                'id'       => $parts[0],
                'title'    => $parts[1],
                'duration' => $parts[2]
            ];
        }

        $state = [
            'results' => $results,
            'page'    => 0,
            'per_page' => 10
        ];

        $stateKey = "ytsearch_{$this->chat_id}";
        file_put_contents(storage_path("app/ytsearch_{$this->chat_id}.json"), json_encode($state));

        $service->showSearchResults($this->chat_id, $state, $this->token);
    }
}
