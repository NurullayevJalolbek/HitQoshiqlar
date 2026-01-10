<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TelegramBotHandlerController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::post('/telegram/webhook', [TelegramBotHandlerController::class, 'webhook']);
