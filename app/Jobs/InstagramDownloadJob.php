<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;


class InstagramDownloadJob implements ShouldQueue
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
        $saveDir = storage_path('app/instagram');

        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0755, true);
        }

        $fileName = $saveDir . '/' . uniqid('insta_') . '.mp4';
        $format = 'bv*[height<=1080]+ba/b[ext=mp4]/b[ext=mp4]/b';

        $command = escapeshellcmd($this->ytdlpPath) . ' '
            . '-f ' . escapeshellarg($format) . ' '
            . '--merge-output-format mp4 '
            . '--no-playlist --no-warnings --quiet '
            . '-o ' . escapeshellarg($fileName) . ' '
            . escapeshellarg($this->url)
            . ' 2>&1';

        exec($command, $output, $status);


        if ($status !== 0 || !file_exists($fileName) || filesize($fileName) < 50 * 1024) {
            sendMessage(
                $this->chat_id,
                "❌ Video yuklab bo‘lmadi.\nInstagram vaqtincha ruxsat bermayapti 😕",
                $this->token,
                null,
                $this->message_id
            );
            return;
        }

        preg_match('~/reel/([^/]+)/~', $this->url, $m);
        $reelCode = $m[1] ?? null; // DSXTl28DGte


        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text' => '❌',
                        'callback_data' => "clear"
                    ],
                    [
                        'text' => '🎵',
                        'callback_data' => 'acr|instagram|' . $this->message_id,
                    ]
                ]
            ]
        ];




        // Telegramga video yuboramiz
        $res = Http::attach(
            'video',
            fopen($fileName, 'r'),
            basename($fileName)
        )->post("https://api.telegram.org/bot{$this->token}/sendVideo", [
            'chat_id' => $this->chat_id,
            'reply_to_message_id' => $this->message_id,
            'caption' => '📥 @HitQoshiqlarBot orqali yuklab olindi',
            'supports_streaming' => true,
            'reply_markup' => json_encode($keyboard),
        ]);

        @unlink($fileName);
    }
}
