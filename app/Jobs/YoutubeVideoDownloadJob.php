<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class YoutubeVideoDownloadJob implements ShouldQueue
{
    use Queueable;

    protected $chat_id;
    protected $message_id;
    protected $url;
    protected $token;
    protected $ytdlpPath;
    

    /**
     * Create a new job instance.
     */
    public function __construct($chat_id, $message_id, $url)
    {
        $this->chat_id = $chat_id;
        $this->message_id = $message_id;
        $this->url = $url;
          $this->token = config("services.telegram.bot_token");
        $this->ytdlpPath = '/opt/homebrew/bin/yt-dlp';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
    }
}
