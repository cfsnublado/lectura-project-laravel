<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('user')->group(function() {
    Route::post(
        'auth-token',
        [
            'as' => 'api.user.token',
            'uses' => 'User\UserApiController@authToken',
        ]
    );
});

Route::prefix('blog')->group(function() {
    Route::middleware('auth:sanctum')->post(
        'import-post',
        [
            'as' => 'api.blog.post.import',
            'uses' => 'Blog\PostController@importPost',
        ]
    );
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
    ]);
    Route::apiResource('post_audios', 'Blog\PostAudioApiController')->names([
        'index' => 'api.blog.post_audios.list',
        'show' => 'api.blog.post_audio.show',
        'destroy' => 'api.blog.post_audio.destroy'
    ]);
    Route::apiResource('posts.post_audios', 'Blog\PostPostAudioApiController')->names([
        'index' => 'api.blog.post.post_audios.list',
    ]);
});

Route::prefix('dbx')->group(function() {
    Route::get(
        'user-files',
        [
            'as' => 'api.dbx.user_files',
            'uses' => 'Dropbox\DropboxController@userFiles',
        ]
    );
    Route::post(
        'shared-link',
        [
            'as' => 'api.dbx.shared_link',
            'uses' => 'Dropbox\DropboxController@sharedLink',
        ]
    );
    Route::post(
        'upload-file',
        [
            'as' => 'api.dbx.upload_file',
            'uses' => 'Dropbox\DropboxController@uploadFile',
        ]
    );
    Route::delete(
        'delete-file',
        [
            'as' => 'api.dbx.delete_file',
            'uses' => 'Dropbox\DropboxController@deleteFile',
        ]
    );
});




