<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use App\Http\Resources\Blog\Post as PostResource;
use App\Http\Resources\Blog\PostCollection;

class ProjectPostApiController extends Controller
{
    /**
     * A nested controller for posts belonging
     * to a specified project.
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_id)
    {
        $posts = Post::where('project_id', $project_id)->paginate(10);
        return new PostCollection($posts);
    }
}
