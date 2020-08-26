<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\ProjectMember;

class ProjectMemberSeeder extends Seeder
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
        $author = factory(User::class)->create([
            'username' => 'author'
        ]);
        ProjectMember::create([
            'project_id' => $project->id,
            'member_id' => $author->id,
            'role' => ProjectMember::ROLE_AUTHOR,
        ]);
        $editor = factory(User::class)->create([
            'username' => 'editor'
        ]);
        ProjectMember::create([
            'project_id' => $project->id,
            'member_id' => $editor->id,
            'role' => ProjectMember::ROLE_EDITOR,
        ]);
        $admin = factory(User::class)->create([
            'username' => 'admin'
        ]);
        ProjectMember::create([
            'project_id' => $project->id,
            'member_id' => $admin->id,
            'role' => ProjectMember::ROLE_ADMIN,
        ]);
    }
}
