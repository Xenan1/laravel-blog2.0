<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PostFactory extends Factory
{
    public function definition()
    {
        return [
            'head' => $this->faker->sentence(),
            'text' => $this->faker->text(300),
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'category_id' => $this->faker->numberBetween(1, Category::count()),

        ];
    }
}
