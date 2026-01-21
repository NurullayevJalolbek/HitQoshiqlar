<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Message\Contracts\iMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class AdminMessageController extends Controller
{
    public function index(Request $request, iMessageService $service)
    {
        $datas = $service->index($request);

        return view("pages.messages.index", [
            "datas" => $datas
        ]);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'url' => ['required_without:filename'],
            'filename' => ['required_without:url'],
        ]);



        $url = $request->string('url')->toString();
        $fileName = $request->string('filename')->toString();


        if ($url) {
            $isInstagram = Str::contains($url, 'instagram.com');
            $isTikTok    = Str::contains($url, 'tiktok.com') || Str::contains($url, 'vt.tiktok.com');

            if (!$isInstagram && !$isTikTok) {
                return response()->json(['ok' => false, 'message' => 'Only Instagram/TikTok'], 422);
            }

            $cacheKey = 'preview:video:' . sha1($url);

            $existing = Cache::get($cacheKey);
            if ($existing && !empty($existing['key'])) {
                $signedUrl = URL::temporarySignedRoute(
                    'admin.messages.previewVideo',
                    now()->addMinutes(10),
                    ['key' => $existing['key']]
                );

                return response()->json([
                    'ok' => true,
                    'platform' => $isInstagram ? 'instagram' : 'tiktok',
                    'video_url' => $signedUrl,
                    'expires_in' => 600,
                ]);
            }

            // ✅ saqlash joyi
            $dir = storage_path('app/previews');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $key  = Str::random(32);
            $file = $dir . '/' . $key . '.mp4';

            $format = 'bv*[ext=mp4]+ba[ext=m4a]/b[ext=mp4]/b';

            $ytdlp = property_exists($this, 'ytdlpPath') ? $this->ytdlpPath : '/opt/homebrew/bin/yt-dlp';

            // ✅ platformaga qarab command
            if ($isTikTok) {
                $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36';
                $proxy = config('services.tiktok_proxy');

                $cmd = escapeshellcmd($ytdlp) . ' '
                    . ($proxy ? '--proxy ' . escapeshellarg($proxy) . ' ' : '')
                    . '--user-agent ' . escapeshellarg($ua) . ' '
                    . '--referer ' . escapeshellarg('https://www.tiktok.com/') . ' '
                    . '--socket-timeout 90 '
                    . '-R 2 --fragment-retries 3 --retry-sleep 1:3 '
                    . '--no-playlist --no-warnings --quiet '
                    . '-f ' . escapeshellarg($format) . ' '
                    . '--merge-output-format mp4 '
                    . '-o ' . escapeshellarg($file) . ' '
                    . escapeshellarg($url)
                    . ' 2>&1';
            } else {
                $cmd = escapeshellcmd($ytdlp) . ' '
                    . '--no-playlist --no-warnings --quiet '
                    . '-f ' . escapeshellarg($format) . ' '
                    . '--merge-output-format mp4 '
                    . '-o ' . escapeshellarg($file) . ' '
                    . escapeshellarg($url)
                    . ' 2>&1';
            }

            exec($cmd, $out, $status);

            if ($status !== 0 || !file_exists($file) || filesize($file) < 50 * 1024) {
                $debug = implode("\n", $out);

                return response()->json([
                    'ok' => false,
                    'message' => 'Download failed',
                    'platform' => $isInstagram ? 'instagram' : 'tiktok',
                    'debug' => mb_substr($debug, 0, 500),
                ], 500);
            }

            Cache::put($cacheKey, [
                'key' => $key,
                'path' => $file,
                'created_at' => time(),
            ], now()->addMinutes(10));

            $signedUrl = URL::temporarySignedRoute(
                'admin.messages.previewVideo',
                now()->addMinutes(10),
                ['key' => $key]
            );

            return response()->json([
                'ok' => true,
                'platform' => $isInstagram ? 'instagram' : 'tiktok',
                'video_url' => $signedUrl,
                'expires_in' => 600,
            ]);
        } elseif ($fileName) {

            $key = pathinfo($fileName, PATHINFO_FILENAME);

            $filePath = storage_path('app/previews/' . $key . '.mp4');
            if (!file_exists($filePath)) {
                return response()->json([
                    'ok' => false,
                    'message' => 'File not found',
                ], 404);
            }

            $signedUrl = URL::temporarySignedRoute(
                'admin.messages.previewVideo',
                now()->addMinutes(10),
                ['key' => $key]
            );

            return response()->json([
                'ok' => true,
                'video_url' => $signedUrl,
                'expires_in' => 600,
            ]);
        }
    }


    public function previewVideo(Request $request, string $key)
    {
        // signed middleware tekshiradi (10 minutdan keyin avtomatik o‘tmaydi)

        // URL bilan cacheKeyni topish uchun: key orqali faylni qidiramiz
        $dir = storage_path('app/previews');
        $file = $dir . '/' . $key . '.mp4';

        if (!file_exists($file)) {
            return abort(404);
        }

        // video stream uchun yaxshi headerlar
        return response()->file($file, [
            'Content-Type' => 'video/mp4',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }


    public function previewList(Request $request)
    {
        $dir = storage_path('app/previews');

        if (!is_dir($dir)) {
            return response()->json([
                'ok' => true,
                'files' => []
            ]);
        }

        $files = collect(scandir($dir))
            ->filter(fn($f) => str_ends_with($f, '.mp4'))
            ->values();

        return response()->json([
            'ok' => true,
            'files' => $files
        ]);
    }

    public function deletePreview(Request $request, string $key)
    {
        $key = pathinfo($key, PATHINFO_FILENAME); // "abc.mp4" kelsa ham "abc" bo'ladi

        $file = storage_path('app/previews/' . $key . '.mp4');

        if (!file_exists($file)) {
            return response()->json([
                'ok' => false,
                'message' => 'File not found'
            ], 404);
        }

        @unlink($file);

        return response()->json([
            'ok' => true
        ]);
    }

}
