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



    /**
     * Create a new job instance.
     */
    public function __construct($chatId, $videoId)
    {
        $this->chat_id = $chatId;
        $this->videoId = $videoId;
        $this->token = config("services.telegram.bot_token");
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

        $loadingResp = Http::post($sendMessageUrl, [
            'chat_id' => $this->chat_id,
            'text'    => "⌛️",
        ])->json();



        // 1️⃣ DB cache tekshiramiz
        $music = Music::where('yt_id', $this->videoId)->first();

        if ($music && $music->field_id) {
            if($loadingResp){
                Http::post($deleteMessageUrl, [
                    'chat_id'=> $this->chat_id,
                    'message_id' =>$loadingResp['result']['message_id'] ?? null,
                ]);

            }
            Http::post($sendAudioUrl, [
                'chat_id' => $this->chat_id,
                'audio' => $music->field_id,
                'title' => mb_substr($music->title ?? 'Music', 0, 20),
                'caption' => "@HitQoshiqlarBot"
            ]);
            return;
        }

        // 2️⃣ YouTube’dan yuklaymiz
        $videoUrl = "https://www.youtube.com/watch?v=" . $this->videoId;
        $fileName = storage_path("app/public/{$this->videoId}.mp3");

        // 1) Start
        $startTime = microtime(true);

        $command = escapeshellcmd($ytdlpPath) .
            " " . escapeshellarg($videoUrl) .
            " -x --audio-format mp3 --audio-quality 9" .
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


            if($loadingResp){
                Http::post($deleteMessageUrl, [
                    'chat_id'=> $this->chat_id,
                    'message_id' =>$loadingResp['result']['message_id'] ?? null,
                ]);
            }
            

            // 1️⃣ Avval USERga yuboramiz
            $userResponse = Http::timeout(300)
                ->attach('audio', $fp, "{$title}.mp3", ['Content-Type' => 'audio/mpeg'])
                ->post($sendAudioUrl, [
                    'chat_id' => $this->chat_id,
                    'caption' => "@HitQoshiqlarBot"
                ]);

            fclose($fp);

            // 2️⃣ Yana faylni ochib KANALga yuboramiz
            if ($fp2 = fopen($fileName, 'r')) {
                $channelResponse = Http::timeout(300)
                    ->attach('audio', $fp2, "{$title}.mp3", ['Content-Type' => 'audio/mpeg'])
                    ->post($sendAudioUrl, [
                        'chat_id' => $channelId,
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
                        'field_id' => $file_id,
                        'title' => $title
                    ]);
                }
            }
        }


        // 6️⃣ Serverdan o‘chiramiz
        @unlink($fileName);
    }
}
