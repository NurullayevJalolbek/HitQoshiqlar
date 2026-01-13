<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

use App\Services\Contracts\iTelegramBotService;
use App\Services\TelegramBotService;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(iTelegramBotService::class, TelegramBotService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }



     Paginator::defaultView('layouts.pagination');


    }
}
