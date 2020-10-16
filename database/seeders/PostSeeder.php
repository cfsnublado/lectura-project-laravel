<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->delete();
        $user = User::where('username', 'cfs')->firstOrFail();
        $project = Project::where('name', 'Test project')->firstOrFail();
        Post::factory()->create([
            'creator_id' => $user->id,
            'project_id' => $project->id,
            'name' => 'Post A'
        ]);
    }
}
