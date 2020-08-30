<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog\PostAudio;
use App\Http\Resources\Blog\PostAudio as PostAudioResource;
use App\Http\Resources\Blog\PostAudioCollection;

class PostAudioApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return new PostAudioCollection(PostAudio::paginate(10));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new PostAudioResource(PostAudio::find($id));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $postAudio = PostAudio::findOrFail($id);
        $this->authorize('delete', $postAudio);
        $post->delete();

        return response()->json(null, 204);
    }
}
