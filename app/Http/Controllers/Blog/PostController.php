<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StorePost;
use App\Http\Requests\Blog\UpdatePost;
use App\Validation\ImportPostJsonValidator;
use App\Models\Blog\Project;
use App\Models\Blog\Post;
use App\Models\Blog\PostAudio;

class PostController extends Controller
{
    /**
     * Show a post by its slug.
     *
     * @param  str  $slug
     * @return Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view(
            'blog.post_show',
            [
                'project' => $post->project, 
                'post' => $post,
                'hasAudio' => PostAudio::where('post_id', $post->id)->exists(),
                'postAudiosUrl' => route(
                    'api.blog.post.post_audios.list', ['post' => $post->id]
                ),
            ]
        );
    }

    /**
     * Create a new post.
     *
     * @param  str  $projectSlug
     * @return Response
     */
    public function create($projectSlug)
    {
        $project = Project::where('slug', $projectSlug)->firstOrFail();
        $this->authorize('createPost', $project);

        return view('blog.post_create', ['project' => $project]);
    }

    /**
     * Store a newly created post.
     *
     * @param  StorePost  $request
     * @param  int  $projectId
     * @return Response
     */
    public function store(StorePost $request, $projectId)
    {
        $project = Project::findOrFail($projectId);
        $this->authorize('createPost', $project);
        $validated = $request->validated();
        $post = Post::create([
            'creator_id' => Auth::user()->id,
            'project_id' => $project->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'content' => $validated['content'],
        ]);

        return redirect(route('blog.post.show', ['slug' => $post->slug]))
            ->with('success', 'Post created!');
        }

    /**
     * Show the form for editing a post.
     *
     * @param str $slug
     * @return Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $post);
        
        return view(
            'blog.post_edit',
            [
                'project' => $post->project,
                'post' => $post,

            ]
        );
    }

    /**
     * Update the specified post in storage.
     *
     * @param UpdatePost $request
     * @param int $id
     * @return Response
     */
    public function update(UpdatePost $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);
        $validated = $request->validated();
        $post->name =  $validated['name'];
        $post->description = $validated['description'];
        $post->content = $validated['content'];
        $post->save();

        return redirect(route('blog.post.show', ['slug' => $post->slug]))
            ->with('success', 'Post updated!');
    }

    /**
     *
     */
    public function importPost(Request $request)
    {
        $data = json_decode($request->getContent());
        $validator = new ImportPostJsonValidator();
        $schemaResult = $validator->schemaValidation($data);

        if ($schemaResult->isValid()) {
            $project = Project::where('name', $data->project_name)->firstOrFail();
            
            return response()->json(['message' => 'Success'], 200);
        } else {
            $error = $schemaResult->getFirstError();
            return response()->json(
                ['message' => $error->keyword() . ' ' . json_encode($error->keywordArgs())],
                402
            );
        }
    }
}
