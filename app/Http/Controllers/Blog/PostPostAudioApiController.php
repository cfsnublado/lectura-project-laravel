<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog\PostAudio;
use App\Http\Resources\Blog\PostAudio as PostAudioResource;
use App\Http\Resources\Blog\PostAudioCollection;

class PostPostAudioApiController extends Controller
{
    /**
     * A nested controller for post audios belonging
     * to a specified post.
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($post_id)
    {
        $pagination = true;

        if (request()->has('pagination')) {
            $pagination = filter_var(
                request()->query('pagination'),
                FILTER_VALIDATE_BOOLEAN
            );
        }

        if ($pagination) {
            $postAudios = PostAudio::where('post_id', $post_id)->paginate(10);
        } else {
            $postAudios = PostAudio::where('post_id', $post_id)->get();
        }

        return new PostAudioCollection($postAudios);
    }
}
