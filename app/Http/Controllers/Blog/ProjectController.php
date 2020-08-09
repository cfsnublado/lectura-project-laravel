<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Blog\Project;

class ProjectController extends Controller
{
    /**
     * Show a project by its slug value.
     *
     * @param  str  $slug
     * @return Response
     */
    public function project($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        return view('blog.project', ['project' => $project]);
    }

    public function projects() {
        return view('blog.projects');
    }
}
