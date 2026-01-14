<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

use App\Services\TelegramBot\Contracts\iTelegramBotService;
use App\Services\TelegramBot\TelegramBotService;
use App\Services\YoutubeSearch\YoutubeSearchService;
use App\Services\YoutubeSearch\Contracts\iYoutubeSearchService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(iTelegramBotService::class, TelegramBotService::class);
        $this->app->bind(iYoutubeSearchService::class, YoutubeSearchService::class);
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
