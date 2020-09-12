<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreProject;
use App\Http\Requests\Blog\UpdateProject;
use App\Components\FlashMessages;
use App\Models\Blog\Project;

class ProjectController extends Controller
{
    use FlashMessages;

    /**
     * Display a listing of projects.
     *
     * @return Response
     */
    public function index()
    {
        return view(
            'blog.projects_list',
            [
                'projectsUrl' => route('api.blog.projects.list'),
                'projectUrl' => route(
                    'blog.project.show', ['slug' => 'zzz']
                ),
                'projectEditUrl' => route(
                    'blog.project.edit', ['slug' => 'zzz']
                ),
                'projectDeleteUrl' => route(
                    'api.blog.project.destroy', ['project' => 0]
                ),
            ]

        );
    }

    /**
     * Show a project by its slug.
     *
     * @param  str  $slug
     * @return Response
     */
    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        return view(
            'blog.project_show', 
            [
                'project' => $project,
                'postsUrl' => route(
                    'api.blog.project.posts.list',
                    ['project' => $project->id]
                ),
                'postUrl' => route(
                    'blog.post.show', ['slug' => 'zzz']
                ),
                'postEditUrl' => route(
                    'blog.post.edit', ['slug' => 'zzz']
                ),
                'postDeleteUrl' => route(
                    'api.blog.post.destroy', ['post' => 0]
                ),
                'projectUrl' => route(
                    'blog.project.show', ['slug' => $project->slug]
                ),               
            ]
        );
    }

    /**
     * Create a new project.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Project::class);

        return view('blog.project_create');
    }

    /**
     * Store a newly created project.
     *
     * @param  StoreProject  $request
     * @return Response
     */
    public function store(StoreProject $request)
    {
        $this->authorize('create', Project::class);
        $validated = $request->validated();
        $project = Project::create([
            'owner_id' => Auth::user()->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);
        self::success(trans('messages.msg_success_project_create'));

        return redirect(route('blog.project.show', ['slug' => $project->slug]));
    }

    /**
     * Show the form for editing a project.
     *
     * @param str $slug
     * @return Response
     */
    public function edit($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $project);
        
        return view('blog.project_edit', ['project' => $project]);
    }

    /**
     * Update the specified project in storage.
     *
     * @param UpdateProject $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateProject $request, $id)
    {
        $project = Project::findOrFail($id);
        $this->authorize('update', $project);
        $validated = $request->validated();
        $project->name =  $validated['name'];
        $project->description = $validated['description'];
        $project->save();
        self::success(trans('messages.msg_success_project_update'));

        return redirect(route('blog.project.show', ['slug' => $project->slug]));
    }
}
