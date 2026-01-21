<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class YoutubeFormatsJob implements ShouldQueue
{
    use Queueable;

    protected int|string $chat_id;
    protected int|string|null $message_id;
    protected string $url;
    protected string $token;
    protected string $ytdlpPath;


    public function __construct($chat_id, $message_id, $url)
    {
        $this->chat_id = $chat_id;
        $this->message_id = $message_id;

        $clean = preg_replace('/[?&](list|index|start_radio|pp|si)=[^&]+/i', '', (string)$url);
        $clean = rtrim($clean, '?&');
        $this->url = $clean;

        $this->token = (string) config("services.telegram.bot_token");
        $this->ytdlpPath = '/opt/homebrew/bin/yt-dlp';
    }

    public function handle(): void
    {
        if (empty($this->token)) {
            Log::error("Telegram token is empty. Check .env and config/services.php");
            return;
        }

        $data = $this->runYtDlpFast($this->url);

        if (!$data || empty($data['formats']) || !is_array($data['formats'])) {
            Log::warning("YT-DLP FAST: no formats", ['url' => $this->url, 'data_ok' => (bool)$data]);
            $this->tgSendMessage("❌ YouTube formatlarini olib bo‘lmadi 😕");
            return;
        }

        $title   = $data['title'] ?? 'YouTube video';
        $videoId = $data['id'] ?? '';
        $formats = $data['formats'];

        // 1) Formatlarni (height bo‘yicha eng yaxshilarini) ajratamiz
        $choices = $this->buildHeightChoices($formats);

        if (empty($choices)) {
            $this->tgSendMessage("❌ Mos format topilmadi 😕");
            return;
        }

        $rows = [];
        $row = [];

        foreach ($choices as $c) {
            $row[] = [
                'text' => $c['label'],
                'callback_data' => "yt|{$c['label']}",
            ];

            if (count($row) === 2) {
                $rows[] = $row;
                $row = [];
            }
        }
        if (!empty($row)) $rows[] = $row;

        $rows[] = [
            ['text' => '❌', 'callback_data' => "clear"],
            ['text' => '🔉', 'callback_data' => 'acr|youtube|' . (string)($this->message_id ?? 0)],
        ];

        $keyboard = ['inline_keyboard' => $rows];

        $text = "🎬 {$title}\n\nVideoni qaysi formatda yuklamoqchisiz ? \n {$this->url}";

        sendStartWithButtons($this->chat_id, $text, $this->token, $keyboard);
    }

    private function runYtDlpFast(string $url): ?array
    {
        // 3 qator chiqaramiz: title, id, formats(json)
        $cmd = escapeshellcmd($this->ytdlpPath) . ' '
            . '--no-playlist '
            . '--skip-download '
            . '--no-warnings '
            . '--print "%(title)s" '
            . '--print "%(id)s" '
            . '--print "%(formats)j" '
            . escapeshellarg($url)
            . ' 2>&1';

        exec($cmd, $output, $status);


        if ($status !== 0 || empty($output)) return null;

        $title = trim($output[0] ?? '');
        $id    = trim($output[1] ?? '');
        $formatsJson = $output[2] ?? '';

        if ($title === '' || $id === '' || trim($formatsJson) === '') return null;

        $formats = json_decode($formatsJson, true);
        if (!is_array($formats)) return null;

        return [
            'title' => $title,
            'id' => $id,
            'formats' => $formats,
        ];
    }


    // 144p → 2160p eng yaxshilarini tanlaydi
    private function buildHeightChoices(array $formats): array
    {
        $best = [];

        foreach ($formats as $f) {
            if (($f['vcodec'] ?? 'none') === 'none') continue;

            $h = (int)($f['height'] ?? 0);
            if ($h <= 0) continue;

            $id = (string)($f['format_id'] ?? '');
            if ($id === '') continue;

            $score = (float)($f['tbr'] ?? 0);

            if (!isset($best[$h]) || $score > $best[$h]['score']) {
                $best[$h] = [
                    'id' => $id,
                    'label' => "{$h}p",
                    'score' => $score,
                ];
            }
        }

        ksort($best); // 144p → 2160p

        return array_values(array_map(static function ($x) {
            return [
                'id' => $x['id'],
                'label' => $x['label'],
            ];
        }, $best));
    }
}
