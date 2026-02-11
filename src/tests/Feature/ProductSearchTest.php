<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\LikesTableSeeder;

class ProductSearchTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_search_index() // 検索機能テスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);

        $keyword = '時計';
        $response = $this->get('/search?keyword=' . urlencode($keyword));
        $products = $response->viewData('products');

        // 取得できた商品名にキーワードが含まれているか確認
        foreach ($products as $product) {
            $this->assertStringContainsString($keyword, $product->product_name);
        }
    }


    public function test_search_mylist() // 検索キーワードを保持してマイリストへ遷移
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->seed(LikesTableSeeder::class);

        $loginResponse = $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'password',
        ]);

        $loginResponse->assertRedirect('/');

        $keyword = 'コーヒー';
        $response = $this->get('/search?keyword=' . urlencode($keyword) . '&tab=mylist');
        $products = $response->viewData('products');

        // 取得できている商品が0件でないことを確認
        $this->assertNotEmpty($products);

        // 取得できた商品名にキーワードが含まれているか確認
        foreach ($products as $product) {
            $this->assertStringContainsString($keyword , $product->product_name);
        }
    }
}
