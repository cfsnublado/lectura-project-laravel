<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Validation\PostJsonValidator;
use App\Models\Blog\Project;
use App\Models\Blog\Post;
use App\Models\Blog\PostAudio;

class PostImportExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Import post from json data.
     */
    public function import(Request $request)
    {
        $data = json_decode($request->getContent());
        $validator = new PostJsonValidator();
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

    /**
     *
     */
    public function downloadJson($id) {
        $post = Post::findOrFail($id);
        $postAudioData = [];

        foreach ($post->post_audios as $postAudio) {
            $postAudioData[] = [
                'name' => $postAudio->name,
                'audio_url' => $postAudio->audio_url
            ];
        }

        $data = json_encode([
            'project_name' => $post->project->name,
            'name' => $post->name,
            'description' => $post->description,
            'content' => $post->content,
            'post_audios' => $postAudioData
        ], JSON_PRETTY_PRINT);

        $filename = $post->slug . '.json';

        return response()->streamDownload(function () use ($data) {
            echo $data;
        }, $filename);
    }
}
