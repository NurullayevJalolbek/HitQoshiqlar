<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TikTokDownloadJob implements ShouldQueue
{
    use Queueable;

    protected int $chat_id;
    protected int $message_id;
    protected string $url;
    protected string $token;
    protected string $ytdlpPath;

    // Queue settings (stabil uchun)
    public int $tries = 3;       // job o'zi 3 marta qayta urinadi
    public int $backoff = 10;    // 10s kutib qayta urinadi
    public int $timeout = 180;   // 3 min

    public function __construct($chat_id, $message_id, $url)
    {
        $this->chat_id = (int) $chat_id;
        $this->message_id = (int) $message_id;
        $this->url = trim((string) $url);

        $this->token = (string) config("services.telegram.bot_token");
        $this->ytdlpPath = '/opt/homebrew/bin/yt-dlp';
    }

    public function handle(): void
    {
        $saveDir = storage_path('app/tiktok');
        if (!is_dir($saveDir)) mkdir($saveDir, 0755, true);

        $fileName = $saveDir . '/' . uniqid('tiktok_') . '.mp4';

        $format = 'bv*[height<=1080]+ba/b[ext=mp4]/b';
        $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36';
        $proxy = config('services.tiktok_proxy');

        $command = escapeshellcmd($this->ytdlpPath) . ' '
            . ($proxy ? '--proxy ' . escapeshellarg($proxy) . ' ' : '')
            . '--user-agent ' . escapeshellarg($ua) . ' '
            . '--referer ' . escapeshellarg('https://www.tiktok.com/') . ' '
            . '--socket-timeout 90 '
            . '-R 2 --fragment-retries 3 --retry-sleep 1:3 '
            . '--no-playlist --no-warnings --quiet '
            . '-f ' . escapeshellarg($format) . ' '
            . '--merge-output-format mp4 '
            . '-o ' . escapeshellarg($fileName) . ' '
            . escapeshellarg($this->url)
            . ' 2>&1';

        exec($command, $output, $status);

        if ($status !== 0 || !file_exists($fileName) || filesize($fileName) < 50 * 1024) {
            Log::warning('TIKTOK FAIL', [
                'status' => $status,
                'out' => is_array($output) ? implode("\n", array_slice($output, 0, 5)) : (string)$output,
            ]);

            sendMessage(
                $this->chat_id,
                "❌ TikTok video yuklab bo‘lmadi.\nBirozdan keyin yana urinib ko‘ring 😕",
                $this->token,
                null,
                $this->message_id
            );

            @unlink($fileName);
            return;
        }

        $data = [
            'chat_id' => $this->chat_id,
            'caption' => '📥 @HitQoshiqlarBot orqali yuklab olindi',
            'supports_streaming' => true,
        ];
        if (!empty($this->message_id)) $data['reply_to_message_id'] = $this->message_id;

        Http::timeout(60)
            ->attach('video', fopen($fileName, 'r'), basename($fileName))
            ->post("https://api.telegram.org/bot{$this->token}/sendVideo", $data);

        @unlink($fileName);
    }
}
