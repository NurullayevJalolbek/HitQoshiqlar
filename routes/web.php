<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

include __DIR__ . '/auth.php';

include __DIR__ . '/admin.php';


Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('logout', [AdminAuthController::class, 'destroy'])->name('logout');
});

Route::post('/language-change', [LanguageController::class, 'change'])->name('language.change');



