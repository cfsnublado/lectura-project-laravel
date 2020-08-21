<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreProject;
use App\Models\Blog\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     *
     * @return Response
     */
    public function index()
    {
        return view('blog.projects_list');
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

        return view('blog.project_show', ['project' => $project]);
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
     * @param StoreProject $request
     * @param int $id
     * @return Response
     */
    public function update(StoreProject $request, $id)
    {
        $project = Project::findOrFail($id);
        $this->authorize('update', $project);
        $validated = $request->validated();
        $project->name =  $validated['name'];
        $project->description = $validated['description'];
        $project->save();

        return redirect(route('blog.project.show', ['slug' => $project->slug]))
            ->with('success', 'Project updated!');
    }
}
