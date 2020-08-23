<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Blog\Project;

$factory->define(Project::class, function (Faker $faker) {
    return [
      'name' => $faker->unique()->sentence,
      'description' => $faker->text,
    ];
});
