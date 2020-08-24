<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\User\User;
use App\Models\Blog\Project;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'owner_id' => factory(User::class),
        'name' => $faker->unique()->sentence,
        'description' => $faker->text,
    ];
});