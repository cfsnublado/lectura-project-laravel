<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User\User;
use App\Models\Blog\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->delete();
        $user = User::where('username', 'cfs')->firstOrFail();
        Project::create([
            'owner_id' => $user->id,
            'name' => 'Project A',
            'description' => 'This is Project A',
        ]);
        Project::create([
            'owner_id' => $user->id,
            'name' => 'Project B',
            'description' => 'This is Project B',
        ]); 
    }
}
