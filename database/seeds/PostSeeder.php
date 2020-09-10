<?php

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
        $project = Project::where('name', 'Project A')->firstOrFail();
        factory(Post::class)->create([
            'creator_id' => $user->id,
            'project_id' => $project->id,
            'name' => 'Post A'
        ]);
        factory(Post::class)->create([
            'creator_id' => $user->id,
            'project_id' => $project->id,
            'name' => 'Post B'
        ]);
        factory(Post::class)->create([
            'creator_id' => $user->id,
            'project_id' => $project->id,
            'name' => 'Post C'
        ]);

        $project = Project::where('name', 'Medio rey')->firstOrFail();
        Post::create([
            'creator_id' => $user->id,
            'project_id' => $project->id,
            'name' => 'Venganza',
            'description' => 'Un fragmento del libro _Medio rey_, de Joe Abercrombie.',
            'content' => '
> Juré vengarme de los asesinos de mi padre. Seré medio hombre, pero pronuncié un juramento entero.

Yarvi, el hijo menor del rey, nació con una malformación en una mano que ha llevado a todo el mundo, incluso a su propio padre, a considerarlo «medio hombre». Por eso, en lugar de formarse como guerrero, al igual que el resto de varones de su estirpe, se ha dedicado a estudiar para convertirse en uno de los clérigos del reino. Sin embargo, en la víspera de la última prueba para ingresar en esta poderosa orden de sabios, a Yarvi le llega la noticia de que su padre y su hermano han sido asesinados. 

Él es el nuevo rey.

Pero tras una terrible traición a manos de sus seres queridos, Yarvi se encontrará solo en un mundo regido por la fuerza física y los corazones fríos. Incapaz de llevar armadura o de levantar un hacha, deberá afilar y agudizar su mente. Cuando se junta a su alrededor una extraña hermandad de almas perdidas, descubrirá que esos compañeros inesperados tal vez puedan ayudarle a convertirse en el hombre que quiere ser.
            '
        ]);
    }
}
