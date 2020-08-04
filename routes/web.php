<?php

use Illuminate\Support\Facades\Route;

Route::get(
    'locale/{locale}',
    ['as' => 'language.set_locale', 'uses'=>'LanguageController@setLocale']
);

$locales = Config::get('app.available_languages');
$locale = Request::segment(1);

if (!array_key_exists($locale, $locales)) {
    $locale = '';
}

Route::middleware(['locale'])->prefix($locale)->group(function () {
    Route::get('/', ['as' => 'app.home', 'uses' => 'AppController@home']);
    
    Route::prefix('security')->group(function() {
        Route::get('login', ['as' => 'security.login', 'uses' => 'SecurityController@showLogin']);
    });
});
