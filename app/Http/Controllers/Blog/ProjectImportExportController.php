<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Validation\Blog\ProjectJsonValidator;
use App\Validation\Blog\ProjectValidation;
use App\Models\Blog\Project;
use App\Models\Blog\Post;
use App\Models\Blog\PostAudio;

class ProjectImportExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Import project from json data.
     */
    public function import(Request $request)
    {
        $data = json_decode($request->getContent());
        $validator = new ProjectJsonValidator();
        $schemaResult = $validator->schemaValidation($data);

        if ($schemaResult->isValid()) {
            $project = Project::where([
                ['uuid', $data->uuid],
                ['name', $data->name]
            ])->first();

            if ($project) {
                $this->authorize('replace', $project);
                $project->delete();
            } else {
                $this->authorize('create', Project::class);
            }
            $validator = Validator::make(
                json_decode($request->getContent(), true),
                ProjectValidation::rulesStore()
            );

            if ($validator->fails()) {
                return response()->json(
                    ['message' => "Invalid project data"],
                    402
                );
            }

            $project = Project::create([
                'uuid' => $data->uuid,
                'owner_id' => Auth::user()->id,
                'name' => $data->name,
                'description' => $data->description,
            ]);

            // Create posts
            foreach ($data->posts as $postData) {
                $post = Post::create([
                    'project_id' => $project->id,
                    'creator_id' => Auth::user()->id,
                    'name' => $postData->name,
                    'description' => $postData->description,
                    'content' => $postData->content
                ]);

                foreach ($postData->post_audios as $postAudioData) {
                    PostAudio::create([
                        'post_id' => $post->id,
                        'creator_id' => Auth::user()->id,
                        'name' => $postAudioData->name,
                        'audio_url' => $postAudioData->audio_url
                    ]);
                }
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
     * Download project json from page.
     */
    public function downloadJson($id)
    {
        $project = Project::findOrFail($id);
        $postData = [];

        foreach ($project->posts as $post) {
            $postAudioData = [];

            foreach ($post->post_audios as $postAudio) {
                $postAudioData[] = [
                    'name' => $postAudio->name,
                    'audio_url' => $postAudio->audio_url
                ];
            }

            $postData[] = [
                'language' => $post->language,
                'name' => $post->name,
                'description' => $post->description,
                'content' => $post->content,
                'post_audios' => $postAudioData
            ];
        }

        $data = json_encode([
            'uuid' => $project->uuid,
            'name' => $project->name,
            'description' => $project->description,
            'posts' => $postData
        ], JSON_PRETTY_PRINT);

        $filename = $project->slug . '.json';

        // Last-check schema validation before sending the data out.
        $decodedData = json_decode($data);
        $validator = new ProjectJsonValidator();
        $schemaResult = $validator->schemaValidation($decodedData);

        if ($schemaResult->isValid()) {
            return response()->streamDownload(function () use ($data) {
                echo $data;
            }, $filename);
        } else {
            $error = $schemaResult->getFirstError();
            $errorMsg = $error->keyword() . ' ' . json_encode($error->keywordArgs());
            Log::error("Invalid schema in project download. " . $errorMsg);

            return redirect()->back();
        }
    }
}