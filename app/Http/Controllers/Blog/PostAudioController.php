<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Validation\Blog\PostAudioValidation;
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
     * @param  Request  $request
     * @param  int  $post_id
     * @return Response
     */
    public function store(Request $request, $post_id)
    {
        $post = Post::findOrFail($post_id);
        $project = $post->project;
        $this->authorize('createPostAudio', $project);
        $validated = $this->validate(
            $request,
            PostAudioValidation::rulesStore()
        );
        $postAudio = PostAudio::create([
            'creator_id' => Auth::user()->id,
            'post_id' => $post->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'audio_url' => $validated['audio_url'],
        ]);
        self::success(trans('messages.msg_success_post_audio_create'));

        return redirect(route('blog.post.show', ['slug' => $post->slug]));
    }

    /**
     * Edit post audio.
     *
     * @param  integer  $id
     * @return Response
     */
    public function edit($id)
    {
        $postAudio = PostAudio::findOrFail($id);
        $post = $postAudio->post;
        $project = $postAudio->post->project;
        $this->authorize('update', $postAudio);

        return view(
            'blog.post_audio_edit',
            [
                'project' => $project, 
                'post' => $post,
                'postAudio' => $postAudio
            ]
        );
    }

    /**
     * Update the specified post audio in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $postAudio = PostAudio::findOrFail($id);
        $post = $postAudio->post;
        $this->authorize('update', $postAudio);
        $validated = $this->validate(
            $request,
            PostAudioValidation::rulesUpdate($postAudio->id)
        );
        $postAudio->name =  $validated['name'];
        $postAudio->description = $validated['description'];
        $postAudio->audio_url = $validated['audio_url'];
        $postAudio->save();
        self::success(trans('messages.msg_success_post_audio_update'));

        return redirect(
            route(
                'blog.post.post_audios.list',
                ['post_id' => $post->id]
            )
        );
    }
}
