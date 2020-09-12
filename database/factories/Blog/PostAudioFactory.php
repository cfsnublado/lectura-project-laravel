<?php

namespace Database\Factories\Blog;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User\User;
use App\Models\Blog\Post;
use App\Models\Blog\PostAudio;

class PostAudioFactory extends Factory
{
    protected $model = PostAudio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_id' => Post::factory(),
            'creator_id' => User::factory(),
            'name' => $this->faker->unique()->sentence,
            'description' => $this->faker->text,
            'audio_url' => $this->faker->url,
        ];
    }
}
