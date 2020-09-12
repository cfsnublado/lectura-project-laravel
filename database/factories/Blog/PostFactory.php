<?php

namespace Database\Factories\Blog;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'creator_id' => User::factory(),
            'name' => $this->faker->unique()->sentence,
            'description' => $this->faker->text,
            'content' => $this->faker->paragraphs(5, true),
        ];
    }
}
