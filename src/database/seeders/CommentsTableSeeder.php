<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Comment;

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::all()->each(function ($product) {
        Comment::factory()
        ->count(3)
        ->sequence(fn ($sequence) => ['sequence' => $sequence->index + 1])
        ->for($product)
        ->create();
    });
    }
}
