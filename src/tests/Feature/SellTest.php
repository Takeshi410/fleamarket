<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\CategoriesTableSeeder;

class SellTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_sell() // 出品登録テスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // 出品画面に遷移
        $response = $this->get('/sell');
        $response->assertStatus(200);

        // 出品する
        $productName = 'テスト商品';
        $brand = 'テスター';
        $description = 'これはテストです';
        $condition = 1;
        $price = 100;
        $categories = [1, 3];

        $response = $this->post('/sell',[
            'product_name' => $productName,
            'brand' => $brand,
            'description' => $description,
            'condition' => $condition,
            'price' => $price,
            'categories' => $categories,
            'product_image' => UploadedFile::fake()->image('test.jpg'),
        ]);
        $response->assertStatus(302);

        // 登録された出品データのidを取得
        $id = \App\Models\Product::max('id');

        // 出品した商品の情報が登録されているか確認
        $this->assertDatabaseHas('products', [
            'product_name' => $productName,
            'brand' => $brand,
            'description' => $description,
            'condition_id' => $condition,
            'price' => $price,
            'image_path' => 'products/product_' . $id .'.jpg'
        ]);

        // カテゴリーが登録されている確認
        foreach ($categories as $category) {
            $this->assertDatabaseHas('product_category', [
                'category_id' =>$category,
                'product_id' => $id,
            ]);
        }
    }
}
