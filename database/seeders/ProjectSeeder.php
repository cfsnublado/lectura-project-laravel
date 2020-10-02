<?php

namespace Database\Seeders;

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
            'name' => 'Medio rey',
            'description' => 'Primer libro de la trilogía _El mar quebrado_, de Joe Abercrombie',
        ]);
        Project::create([
            'owner_id' => $user->id,
            'name' => 'El arte de pensar',
            'description' => 'Cómo los grandes filósofos pueden estimular nuestro pensamiento crítico.<br><br>José Carlos Ruiz',
        ]);
        Project::create([
            'owner_id' => $user->id,
            'name' => 'El sutil arte de que te importe un carajo',
            'description' => 'Un enfoque disruptivo para vivir una buena vida<br><br>Escrito por Mark Manson<br>Traducido por Anna Roig',
        ]);
        Project::create([
            'owner_id' => $user->id,
            'name' => 'Test project',
            'description' => 'This is a test project',
        ]);
    }
}
