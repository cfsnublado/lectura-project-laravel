<?php

namespace Database\Factories\Blog;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User\User;
use App\Models\Blog\Project;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'owner_id' => User::factory(),
            'name' => $this->faker->unique()->sentence,
            'description' => $this->faker->text,
        ];
    }

}
