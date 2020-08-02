<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;


class LanguageController extends Controller
{
    public function setLocale($locale='en') {
        $url = URL::previous();
        $parsed = parse_url($url);
        $pathArray = explode('/', $parsed['path']);
        $locales = Config::get('app.available_languages');
        $defaultLocale = Config::get('app.fallback_locale', 'en');

        if ($pathArray[1] == '') {
            $parsed['path'] = ($locale != $defaultLocale) ? '/' . $locale : '';
        } elseif (array_key_exists($pathArray[1], $locales)) {
            $pathArray[1] = ($locale != $defaultLocale) ? $locale : '';
            $parsed['path'] = implode('/', $pathArray);
        } else {
            $pathArray[0] = ($locale != $defaultLocale) ? '/' . $locale : '';
            $parsed['path'] = implode('/', $pathArray);
        }

        $resultUrl = build_parsed_url($parsed);

        return redirect($resultUrl);
    }
}
