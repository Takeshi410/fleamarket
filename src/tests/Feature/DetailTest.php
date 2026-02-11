<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ProductCategoryTableSeeder;
use Database\Seeders\LikesTableSeeder;
use Database\Seeders\CommentsTableSeeder;


class DetailTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_detail() // 商品詳細情報の取得テスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ProductCategoryTableSeeder::class);
        $this->seed(LikesTableSeeder::class);
        $this->seed(CommentsTableSeeder::class);

        $response = $this->get('/item/3');
        $product = $response->viewData('product');

        $this->assertSame('products/product_3.jpg', $product->image_path); // 商品画像
        $this->assertSame('玉ねぎ3束', $product->product_name); // 商品名
        $this->assertSame('なし', $product->brand); // ブランド
        $this->assertSame(300, $product->price); // 価格
        $this->assertSame(1, $product->likes_count); // いいね数
        $this->assertSame(3, $product->comments_count); // コメント数
        $this->assertSame('新鮮な玉ねぎ3束のセット', $product->description); // 商品説明
        $this->assertSame('キッチン', $product->categories->first()->category); // カテゴリー
        $this->assertSame('やや傷や汚れあり', $product->condition->condition); // 商品の状態

        // コメント
        $comments = $product->comments;
        $this->assertSame(3, $comments->count()); // コメントのレコード数
        $this->assertSame(3, $comments->filter(fn ($comment) => !is_null($comment->user?->username))->count()); // 取得できているユーザー数
        $this->assertSame(3, $comments->filter(fn ($comment) => !is_null($comment->comment))->count()); // NULLでないコメント数
    }


    public function test_category() //カテゴリーの取得テスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ProductCategoryTableSeeder::class);

        $response = $this->get('/item/1');
        $product = $response->viewData('product');
        $categories = $product->categories;

        // 複数のカテゴリーを取得できているか確認
        $this->assertSame(3, $categories->filter(fn ($category) => !is_null($category->category))->count());
    }
}
