<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Blog\Post;
use App\Models\Blog\Project;
use App\Models\User\User;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class),
        'creator_id' => factory(User::class),
        'name' => $faker->unique()->sentence,
        'description' => $faker->text,
        'content' => $faker->paragraphs(5, true),
    ];
});
