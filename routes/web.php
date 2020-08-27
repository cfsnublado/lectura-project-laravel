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
    Route::post('/app-session', ['as' => 'app.session', 'uses' => 'App\AppController@session']);

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

        Route::prefix('auth')->group(function() {
            Route::get(
                'project/create',
                [
                    'as' => 'blog.project.create',
                    'uses' => 'Blog\ProjectController@create',
                ]
            )->middleware('auth');
            Route::post(
                'project/store',
                [
                    'as' => 'blog.project.store',
                    'uses' => 'Blog\ProjectController@store'
                ]
            );
            Route::get(
                'project/{slug}/edit',
                [
                    'as' => 'blog.project.edit',
                    'uses' => 'Blog\ProjectController@edit'
                ]
            )->middleware('auth');
            Route::post(
                'project/{id}/update',
                [
                    'as' => 'blog.project.update',
                    'uses' => 'Blog\ProjectController@update'
                ]
            );
            Route::get(
                'project/{slug}/post/create',
                [
                    'as' => 'blog.post.create',
                    'uses' => 'Blog\PostController@create',
                ]
            )->middleware('auth');
            Route::post(
                'project/{projectId}/post/store',
                [
                    'as' => 'blog.post.store',
                    'uses' => 'Blog\PostController@store'
                ]
            );
            Route::get(
                'post/{slug}/edit',
                [
                    'as' => 'blog.post.edit',
                    'uses' => 'Blog\PostController@edit',
                ]
            )->middleware('auth');
            Route::post(
                'post/{id}/update',
                [
                    'as' => 'blog.post.update',
                    'uses' => 'Blog\PostController@update'
                ]
            );
        });

        Route::get(
            'projects',
            [
                'as' => 'blog.projects.list',
                'uses' => 'Blog\ProjectController@index'
            ]
        );
        Route::get(
            'project/{slug}',
            [
                'as' => 'blog.project.show',
                'uses' => 'Blog\ProjectController@show'
            ]
        );
        Route::get(
            'post/{slug}',
            [
                'as' => 'blog.post.show',
                'uses' => 'Blog\PostController@show'
            ]
        );
    });

    Route::prefix('dbx')->group(function() {
        Route::prefix('auth')->group(function() {
           Route::get(
                '/',
                [
                    'as' => 'dbx.project.index',
                    'uses' => 'Dropbox\DropboxController@index',
                ]
            )->middleware('auth');
        });
    });

});
