<?php

use App\Http\Controllers\Admin\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/projects/list', [ProjectController::class, 'list']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::put('/projects/{id}', [ProjectController::class, 'update']);
Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);

