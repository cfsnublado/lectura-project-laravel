<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Blog\Post;

class PostPostAudioController extends Controller
{
    public function index($post_id)
    {
        $post = Post::findOrFail($post_id);
        $project = $post->project;

        return view(
            'blog.post_post_audios_list',
            [
                'project' => $project,
                'post' => $post,
                'postAudiosUrl' => route(
                    'api.blog.post.post_audios.list', ['post' => $post_id]
                ),
                'postViewUrl' => route(
                    'blog.post.show', ['slug' => $post->slug]
                ),
                'postAudioEditUrl' => route(
                    'blog.post_audio.edit', ['id' => '0']
                ),
                'postAudioDeleteUrl' => route(
                    'api.blog.post_audio.destroy', ['post_audio' => '0']
                ),
            ]

        );
    }
}
