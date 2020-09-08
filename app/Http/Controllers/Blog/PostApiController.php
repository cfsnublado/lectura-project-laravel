<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Validation\ImportPostJsonValidator;
use App\Models\Blog\Project;
use App\Models\Blog\Post;
use App\Models\Blog\PostAudio;
use App\Http\Resources\Blog\Post as PostResource;
use App\Http\Resources\Blog\PostCollection;

class PostApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return new PostCollection(Post::paginate(10));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new PostResource(Post::find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);
        $post->delete();

        return response()->json(null, 204);
    }

    /**
     *
     */
    public function import(Request $request)
    {
        $data = json_decode($request->getContent());
        $validator = new ImportPostJsonValidator();
        $schemaResult = $validator->schemaValidation($data);

        if ($schemaResult->isValid()) {
            $project = Project::where('name', $data->project_name)->firstOrFail();
            $post = Post::where(
                [
                    ['project_id', $project->id],
                    ['name', $data->name]
                ])->first();

            if ($post) {
                $this->authorize('replace', $post);
                $post->delete();
            } else {
                $this->authorize('createPost', $project);
            }

            $validator = Validator::make(
                json_decode($request->getContent(), true),
                [
                    'name' => 'required|unique:posts,name',
                    'description' => '',
                    'content' => 'required',
                ]
            );

           if ($validator->fails()) {
                return response()->json(
                    ['message' => "Invalid post data"],
                    402
                );
            }

            $post = Post::create([
                'project_id' => $project->id,
                'creator_id' => Auth::user()->id,
                'name' => $data->name,
                'description' => $data->description,
                'content' => $data->content
            ]);

            // Add post audios
            foreach ($data->post_audios as $postAudio) {
                PostAudio::create([
                    'post_id' => $post->id,
                    'creator_id' => Auth::user()->id,
                    'name' => $postAudio->name,
                    'audio_url' => $postAudio->audio_url
                ]);
            }

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
