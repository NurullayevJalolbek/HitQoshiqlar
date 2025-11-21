<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Closure;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        App::setLocale(auth()->user()?->locale ?? 'uz');

        return $next($request);
    }
}
