<?php

use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/projects/list', [ProjectController::class, 'list']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::put('/projects/{id}', [ProjectController::class, 'update']);
Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

Route::get('dashboard', [DashboardController::class, 'index']);
