<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::query()->inRandomOrder()->value('id'),
            'sequence' => 1,
            'user_id' => User::query()->inRandomOrder()->value('id'),
            'comment' => $this->faker->realText(80),
        ];
    }
}