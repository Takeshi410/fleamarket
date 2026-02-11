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

class LikeTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_like_add() // いいね追加テスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ProductCategoryTableSeeder::class);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->get('/item/6');
        $product = $response->viewData('product');
        $beforeCount = $product->likes_count;

        // いいね操作
        $response = $this->post(route('item.like.toggle', ['item_id' => $product->id]));
        $response->assertRedirect();

        // いいねした商品が登録されているか確認
        $this->assertDatabaseHas('likes', [
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        $response = $this->get('/item/' . $product->id);
        $product = $response->viewData('product');
        $afterCount = $product->likes_count;

        // いいねのカウントが1増えているか確認
        $this->assertSame($beforeCount + 1, $afterCount);
    }


    public function test_like_icon() // いいねアイコンテスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ProductCategoryTableSeeder::class);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->get('/item/6');
        $product = $response->viewData('product');
        $beforeCount = $product->likes_count;

        // いいね操作
        $response = $this->post(route('item.like.toggle', ['item_id' => $product->id]));
        $response->assertRedirect();

        $response = $this->get('/item/' . $product->id);

        // 表示されている いいねアイコンがonになっているか確認
        $response->assertSee('img/default/heart_on.png', false);
    }


    public function test_like_delete() // いいね削除テスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ProductCategoryTableSeeder::class);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->get('/item/6');
        $product = $response->viewData('product');

        // いいね操作（追加）
        $response = $this->post(route('item.like.toggle', ['item_id' => $product->id]));
        $response->assertRedirect();

        // いいねした商品が登録されているか確認
        $this->assertDatabaseHas('likes', [
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        $response = $this->get('/item/' . $product->id);
        $product = $response->viewData('product');
        $beforeCount = $product->likes_count;

        // いいね操作（削除）
        $response = $this->post(route('item.like.toggle', ['item_id' => $product->id]));
        $response->assertRedirect();

        // いいねしていしたデータが削除されていることを確認
        $this->assertDatabaseMissing('likes', [
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        $response = $this->get('/item/' . $product->id);
        $product = $response->viewData('product');
        $afterCount = $product->likes_count;

        // いいねのカウントが1減っているか確認
        $this->assertSame($beforeCount - 1, $afterCount);
    }
}
