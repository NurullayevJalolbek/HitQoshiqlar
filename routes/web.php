<?php

use Illuminate\Support\Facades\Route;

include __DIR__ . '/auth.php';
include __DIR__ . '/admin.php';


Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});
