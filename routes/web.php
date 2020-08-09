<?php

use Illuminate\Support\Facades\Route;

Route::get(
    'locale/{locale}',
    [
        'as' => 'language.set_locale',
        'uses'=>'LanguageController@setLocale'
    ]
);

$locales = Config::get('app.available_languages');
$locale = Request::segment(1);

if (!array_key_exists($locale, $locales)) {
    $locale = '';
}

Route::middleware(['locale'])->prefix($locale)->group(function () {
    Route::get('/', ['as' => 'app.home', 'uses' => 'App\AppController@home']);
    Route::get('/secret', ['as' => 'app.secret', 'uses' => 'App\AppController@secret']);

    Route::prefix('security')->group(function() {
        Route::get(
            'login',
            [
                'as' => 'security.login',
                'uses' => 'Security\LoginController@showLogin'
            ]
        );
        Route::post(
            'authenticate',
            [
                'as' => 'security.authenticate',
                'uses' => 'Security\LoginController@authenticate'
            ]
        ); 
        Route::get(
            'logout', 
            [
                'as' => 'security.logout',
                'uses' => 'Security\LoginController@logout'
            ]
        );
    });

    Route::prefix('blog')->group(function() {
        Route::get(
            'projects',
            [
                'as' => 'blog.projects',
                'uses' => 'Blog\ProjectController@projects'
            ]
        );
        Route::get(
            'project/{slug}',
            [
                'as' => 'blog.project',
                'uses' => 'Blog\ProjectController@project'
            ]
        );
    });

});
