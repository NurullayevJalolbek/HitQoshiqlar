<?php

namespace App\Providers;

use App\Services\Message\Contracts\iMessageService;
use App\Services\Message\MessageService;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

use App\Services\TelegramBot\Contracts\iTelegramBotService;
use App\Services\TelegramBot\TelegramBotService;
use App\Services\User\Contracts\iUserService;
use App\Services\User\UserService;
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
        $this->app->bind(iUserService::class, UserService::class);
        $this->app->bind(iMessageService::class, MessageService::class);

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
