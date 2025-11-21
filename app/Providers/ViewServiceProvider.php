<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Language;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // odatda bo'sh bo'ladi
    }

    public function boot(): void
    {
        if (Schema::hasTable('languages')) {
            $languages = Language::orderBy('id')->get();
            $activeLanguage = Language::where('url', auth()->user()?->locale)->first();

            View::share('languages', $languages);
            View::share('activeLanguage', $activeLanguage);
        }
    }
}
