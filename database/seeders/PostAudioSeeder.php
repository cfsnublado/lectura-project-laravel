<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User\User;
use App\Models\Blog\Post;
use App\Models\Blog\PostAudio;

class PostAudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_audios')->delete();
        $user = User::where('username', 'cfs')->firstOrFail();
        $post = Post::where('name', 'Medio rey: sinopsis')->firstOrFail();
        PostAudio::create([
            'creator_id' => $user->id,
            'post_id' => $post->id,
            'name' => 'Medio rey',
            'audio_url' => 'https://www.dropbox.com/s/d0q15z13l72aceo/mediorey.mp3?dl=1'
        ]);
    }
}
