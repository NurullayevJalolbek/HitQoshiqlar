<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('pages.dashboard.index');
});



    include __DIR__ . '/auth.php';



//Route::group(['middleware' => ['locale']], function () {
//    include __DIR__ . '/auth.php';
//    include __DIR__ . '/admin.php';
//});
