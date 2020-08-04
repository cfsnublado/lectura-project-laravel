<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1);
        $languages = Config::get('app.available_languages');

        if (!array_key_exists($locale, $languages)) {
            $locale = Config::get('app.fallback_language', 'en');
        } 

        Session::put('app.locale', $locale);
        App::setLocale($locale);

        return $next($request);
    }
}
