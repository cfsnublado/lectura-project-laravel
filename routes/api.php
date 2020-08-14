<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('blog')->group(function() {

    Route::apiResource('projects', 'Blog\ProjectApiController')->names([
        'index' => 'api.blog.projects.list',
        'show' => 'api.blog.project.show',
        'destroy' => 'api.blog.project.destroy'
    ]);
    // Route::get(
    //     'projects',
    //     [
    //         'as' => 'api.blog.projects',
    //         'uses' => 'Blog\ProjectApiController@index'
    //     ]
    // );
    // Route::get(
    //     'project/{id}',
    //     [
    //         'as' => 'api.blog.project',
    //         'uses' => 'Blog\ProjectApiController@show'
    //     ]
    // );

    //Route::post('books/{book}/ratings', 'RatingController@store');

});



