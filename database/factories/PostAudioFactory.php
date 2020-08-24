<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Blog\PostAudio;
use App\Models\Blog\Post;
use App\Models\User\User;

$factory->define(PostAudio::class, function (Faker $faker) {
    return [
        'post_id' => factory(Post::class),
        'creator_id' => factory(User::class),
        'name' => $faker->unique()->sentence,
        'description' => $faker->text,
        'audio_url' => $faker->url,
    ];
});
