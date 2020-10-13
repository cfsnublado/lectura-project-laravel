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
            'uuid' => '98eaba9e-ac37-4f44-96d6-3855b88a8885',
            'name' => 'Medio rey',
            'description' => 'Primer libro de la trilogía _El mar quebrado_ - Joe Abercrombie',
        ]);
        Project::create([
            'owner_id' => $user->id,
            'uuid' => '67b6cc45-4ffe-4ce1-9dce-ac0d8945c16d',
            'name' => 'El arte de pensar',
            'description' => 'Cómo los grandes filósofos pueden estimular nuestro pensamiento crítico - José Carlos Ruiź',
        ]);
        Project::create([
            'owner_id' => $user->id,
            'uuid' => '23c8db97-cc12-4bcd-8458-2425ee5b58f1',
            'name' => 'El sutil arte de que te importe un carajo',
            'description' => 'Un enfoque disruptivo para vivir una buena vida - Mark Manson',
        ]);
        Project::create([
            'owner_id' => $user->id,
            'uuid' => '6b91e839-4a4e-4abf-bf99-bad9f2b69172',
            'name' => 'Until the End of Time',
            'description' => 'Mind, Matter, and Our Search for Meaning in an Evolving Universe - Brian Greene',
        ]);
        Project::create([
            'owner_id' => $user->id,
            'uuid' => '235e9686-1618-4025-8433-f50f1112bb7e',
            'name' => 'Test project',
            'description' => 'This is a test project',
        ]);
    }
}
