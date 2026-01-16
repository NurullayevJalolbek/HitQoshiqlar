<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TelegramBotHandlerController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::post('/telegram/webhook', [TelegramBotHandlerController::class, 'webhook']);

Route::post('/test-download', function (Request $request) {
    $url = $request->url;

    $cmd = 'yt-dlp -f "bv*+ba/b" '
        . '--merge-output-format mp4 '
        . escapeshellarg($url)
        . ' -o ' . escapeshellarg(storage_path('app/test.mp4'))
        . ' 2>&1';

    exec($cmd, $out);

    return response()->json([
        'status' => 'ok',
        'log' => $out
    ]);
});
