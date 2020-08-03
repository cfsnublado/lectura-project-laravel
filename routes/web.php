<?php

use Illuminate\Support\Facades\Route;

Route::get(
    'locale/{locale?}',
    ['as' => 'language.set_locale', 'uses'=>'LanguageController@setLocale']
);

Route::middleware(['locale', 'default.url.locale'])->prefix('{url_locale?}')->group(function () {
    Route::get('/', ['as' => 'app.home', 'uses' => 'AppController@home']);
});
