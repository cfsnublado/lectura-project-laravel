<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Model\User\User;
use App\Model\Blog\Project;
use App\Model\Blog\Post;

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
        $project = Project::where('name', 'Project A')->firstOrFail();
        Post::create([
            'creator_id' => $user->id,
            'project_id' => $project->id,
            'name' => 'Post A',
            'content' => 'This is Post A',
        ]);
        Post::create([
            'creator_id' => $user->id,
            'project_id' => $project->id,
            'name' => 'Post B',
            'content' => 'This is Post B',
        ]);
        Post::create([
            'creator_id' => $user->id,
            'project_id' => $project->id,
            'name' => 'Post C',
            'content' => 'This is Post C',
        ]);
    }
}
