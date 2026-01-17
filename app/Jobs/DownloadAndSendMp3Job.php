<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

use App\Models\Music;
use Illuminate\Support\Facades\Http;


class DownloadAndSendMp3Job implements ShouldQueue
{
    use Queueable;

    public string $chat_id;
    public string $videoId;
    protected string $token;
    protected string $message_id;

    protected $loadingResp;




    /**
     * Create a new job instance.
     */
    public function __construct($chatId, $videoId, $message_id, $loadingResp)
    {
        $this->chat_id = $chatId;
        $this->videoId = $videoId;
        $this->token = config("services.telegram.bot_token");
        $this->loadingResp = $loadingResp;
        $this->message_id = $message_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $sendMessageUrl = "https://api.telegram.org/bot{$this->token}/sendMessage";
        $deleteMessageUrl = "https://api.telegram.org/bot{$this->token}/deleteMessage";
        $sendAudioUrl = "https://api.telegram.org/bot{$this->token}/sendAudio";

        $ytdlpPath = '/opt/homebrew/bin/yt-dlp';
        $channelId = '-1003397606314';

        // 1️⃣ DB cache tekshiramiz
        // $music = Music::where('yt_id', $this->videoId)->first();

        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text' => '❌',
                        'callback_data' => 'clear'
                    ]
                ]
            ]
        ];



        // 2️⃣ YouTube’dan yuklaymiz
        $videoUrl = "https://www.youtube.com/watch?v=" . $this->videoId;
        $fileName = storage_path("app/public/{$this->videoId}.mp3");

        // 1) Start
        $startTime = microtime(true);

        $command = escapeshellcmd($ytdlpPath) .
            " " . escapeshellarg($videoUrl) .
            " -x --audio-format mp3 --audio-quality 5" .
            " -N 6" .
            " --no-playlist --no-warnings --quiet" .
            " --no-check-certificate --no-call-home" .
            " --postprocessor-args " . escapeshellarg("-threads 8") .
            " -o " . escapeshellarg($fileName) .
            " 2>&1";

        // 2) Run
        $output = [];
        exec($command, $output);

        // 3) End + time
        $executionTime = round(microtime(true) - $startTime, 3);


        // 5) Log (oxirgi 10 qator)

        Log::info("YTDLP+FFMPEG TIME", [
            'seconds'    => $executionTime,
        ]);


        if (!file_exists($fileName) || filesize($fileName) < 50000) {
            return;
        }

        if ($fp = fopen($fileName, 'r')) {

            $title  = trim(shell_exec("$ytdlpPath --get-title " . escapeshellarg($videoUrl)));

            [$artist, $trackTitle] = $this->splitArtistTitle($title);


            if ($this->loadingResp) {
                Http::post($deleteMessageUrl, [
                    'chat_id' => $this->chat_id,
                    'message_id' => (int) $this->loadingResp['result']['message_id']
                ]);
            }


            // 1️⃣ Avval USERga yuboramiz
            $userResponse = Http::timeout(300)
                ->attach('audio', $fp, "{$title}.mp3", ['Content-Type' => 'audio/mpeg'])
                ->post($sendAudioUrl, [
                    'chat_id' => $this->chat_id,
                    'reply_to_message_id' => (int) $this->message_id,
                    'reply_markup' => json_encode($keyboard),
                    'title' => mb_substr($trackTitle, 0, 64),
                    'performer' => mb_substr($artist, 0, 64),
                    'caption' => "@HitQoshiqlarBot"
                ]);


            fclose($fp);

            // 2️⃣ Yana faylni ochib KANALga yuboramiz
            if ($fp2 = fopen($fileName, 'r')) {
                $channelResponse = Http::timeout(300)
                    ->attach('audio', $fp2, "{$title}.mp3", ['Content-Type' => 'audio/mpeg'])
                    ->post($sendAudioUrl, [
                        'chat_id' => $channelId,
                        'title' => mb_substr($trackTitle, 0, 64),
                        'performer' => mb_substr($artist, 0, 64),
                        'caption' => "@HitQoshiqlarBot"
                    ]);

                fclose($fp2);

                // 3️⃣ file_id ni kanal javobidan olamiz (doim ishonchli)
                $channelData = $channelResponse->json();
                $file_id = $channelData['result']['audio']['file_id'] ?? null;

                // 4️⃣ DB ga saqlaymiz
                if ($file_id) {
                    Music::create([
                        'yt_id' => $this->videoId,
                        'file_id' => $file_id,
                        'title' => $trackTitle,
                        'artist' => $artist,
                    ]);
                }
            }
        }


        // 6️⃣ Serverdan o‘chiramiz
        @unlink($fileName);
    }

    private function splitArtistTitle(string $raw): array
    {
        $raw = trim(preg_replace('/\s+/', ' ', $raw));

        // Ummon - Xiyonat  (dashlarni ham ushlaymiz)
        if (preg_match('/^(.+?)\s*[-–—]\s*(.+)$/u', $raw, $m)) {
            return [trim($m[1]), trim($m[2])];
        }

        // topolmasa, hammasini title qilib yuboramiz
        return ['Unknown', $raw];
    }
}
