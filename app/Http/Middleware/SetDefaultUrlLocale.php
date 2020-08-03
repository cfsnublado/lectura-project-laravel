<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class SetDefaultUrlLocale
{
    public function handle($request, Closure $next)
    {

        if (Session::has('app.locale')) {
            $locale = Session::get('app.locale');
            $defaultLocale = Config::get('app.fallback_locale', 'en');
            $urlLocale = ($locale != $defaultLocale) ? $locale : '';
            URL::defaults(['url_locale' => $urlLocale]);
        }

        return $next($request);
    }
}