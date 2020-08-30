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
        $postAudios = PostAudio::where('post_id', $post_id)->paginate(10);
        return new PostAudioCollection($postAudios);
    }
}
