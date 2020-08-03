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
        $locale = $request->route('url_locale');
        $languages = Config::get('app.available_languages', ['en' => 'English']);

        if ($locale) {
            if (!array_key_exists($locale, $languages)) {
                abort(404);
            }
        } else {
            $locale = Config::get('app.fallback_language', 'en');
        }

        Session::put('app.locale', $locale);
        App::setLocale($locale);

        return $next($request);
    }
}
