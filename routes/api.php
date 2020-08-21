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
    Route::apiResource('posts', 'Blog\PostApiController')->names([
        'index' => 'api.blog.posts.list',
        'show' => 'api.blog.post.show',
        'destroy' => 'api.blog.post.destroy'
    ]);
    Route::apiResource('projects.posts', 'Blog\ProjectPostApiController')->names([
        'index' => 'api.blog.project.posts.list',
        'show' => 'api.blog.project.post.show',
        'destroy' => 'api.blog.project.post.destroy'
    ]);
});



