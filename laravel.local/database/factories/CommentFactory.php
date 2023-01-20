<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'post_id' => $this->faker->numberBetween(1, Post::count()),
            'text' => $this->faker->text(30),
        ];
    }
}
