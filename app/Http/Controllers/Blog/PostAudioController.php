<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StorePostAudio;
use App\Models\Blog\Post;
use App\Models\Blog\PostAudio;

class PostAudioController extends Controller
{
    /**
     * Create a new post audio.
     *
     * @param  integer  $post_id
     * @return Response
     */
    public function create($post_id)
    {
        $post = Post::findOrFail($post_id);
        $project = $post->project;
        $this->authorize('createPostAudio', $project);

        return view(
            'blog.post_audio_create',
            ['project' => $project, 'post' => $post]
        );
    }


    /**
     * Store a newly created post audio.
     *
     * @param  StorePostAudio  $request
     * @param  int  $post_id
     * @return Response
     */
    public function store(StorePostAudio $request, $post_id)
    {
        $post = Post::findOrFail($post_id);
        $project = $post->project;
        $this->authorize('createPostAudio', $project);
        $validated = $request->validated();
        $postAudio = PostAudio::create([
            'creator_id' => Auth::user()->id,
            'post_id' => $post->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'audio_url' => $validated['audio_url'],
        ]);
        self::success(trans('messages.msg.success_post_audio_create'));

        return redirect(route('blog.post.show', ['slug' => $post->slug]));
    }
}
