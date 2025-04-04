<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Post::class;
    public function definition(): array
    {

        return [
            'user_id' => User::factory(), // Create a user and associate it with the post
            'title' => $this->faker->sentence, // Generate a random sentence
            'content' => $this->faker->paragraph, // Generate a random paragraph
        ];
    }
}
