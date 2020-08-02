<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get(
    'locale/{locale?}',
    ['as' => 'language.set_locale', 'uses'=>'LanguageController@setLocale']
);

Route::middleware(['locale', 'default.url.locale'])->prefix('{url_locale?}')->group(function () {
    Route::get('/', ['as' => 'app.home', 'uses' => 'AppController@home']);
});
