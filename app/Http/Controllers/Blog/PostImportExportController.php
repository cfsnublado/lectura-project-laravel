<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Validation\Blog\PostJsonValidator;
use App\Validation\Blog\PostValidation;
use App\Models\Blog\Project;
use App\Models\Blog\Post;
use App\Models\Blog\PostAudio;

class PostImportExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
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
            $project = Project::where([
                ['uuid', $data->project_uuid],
                ['name', $data->project_name]
            ])->firstOrFail();
            $post = Post::where(
                [
                    ['project_id', $project->id],
                    ['name', $data->name]
                ]
            )->first();

            if ($post) {
                $this->authorize('replace', $post);
                $post->delete();
            } else {
                $this->authorize('createPost', $project);
            }
            $validator = Validator::make(
                json_decode($request->getContent(), true),
                PostValidation::rulesStore($project->id)
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
            foreach ($data->post_audios as $postAudioData) {
                PostAudio::create([
                    'post_id' => $post->id,
                    'creator_id' => Auth::user()->id,
                    'name' => $postAudioData->name,
                    'audio_url' => $postAudioData->audio_url
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
     * Download post json from page.
     */
    public function downloadJson($id) {
        $post = Post::findOrFail($id);
        $project = $post->project;
        $postAudioData = [];

        foreach ($post->post_audios as $postAudio) {
            $postAudioData[] = [
                'name' => $postAudio->name,
                'audio_url' => $postAudio->audio_url
            ];
        }

        $data = json_encode([
            'project_uuid' => $project->uuid,
            'project_name' => $project->name,
            'language' => $post->language,
            'name' => $post->name,
            'description' => $post->description,
            'content' => $post->content,
            'post_audios' => $postAudioData
        ], JSON_PRETTY_PRINT);

        $filename = $post->slug . '.json';

        // Last-check schema validation before sending the data out.
        $decodedData = json_decode($data);
        $validator = new PostJsonValidator();
        $schemaResult = $validator->schemaValidation($decodedData);

        if ($schemaResult->isValid()) {
            return response()->streamDownload(function () use ($data) {
                echo $data;
            }, $filename);
        } else {
            $error = $schemaResult->getFirstError();
            $errorMsg = $error->keyword() . ' ' . json_encode($error->keywordArgs());
            Log::error("Invalid schema in post download. " . $errorMsg);

            return redirect()->back();
        }
    }
}
