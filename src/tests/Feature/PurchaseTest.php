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

class PurchaseTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_purchase() // 商品購入テスト
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

        // テスト対象商品idを設定
        $itemId = 3;

        // 購入画面へ遷移
        $response = $this->get(route('purchase.index', ['item_id' => $itemId]));
        $response->assertStatus(200);
        $product = $response->viewData('product');

        // 購入操作
        $response = $this->post(route('purchase.checkout',  ['item_id' => $product->id]),[
            'amount' => (int) $product->price,
            'payment_method' => 'card'
        ]);

        // テスト対象商品が購入されたデータを確認
        $this->assertDatabaseHas('purchases', [
            'user_id' => auth()->id(),
            'product_id' => $itemId,
        ]);
    }


    public function test_purchase_sold() // sold表示テスト
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

        // テスト対象商品idを設定
        $itemId = 3;

        // 購入画面へ遷移
        $response = $this->get(route('purchase.index', ['item_id' => $itemId]));
        $product = $response->viewData('product');

        // 購入操作
        $response = $this->post(route('purchase.checkout',  ['item_id' => $product->id]),[
            'amount' => (int) $product->price,
            'payment_method' => 'card'
        ]);

        // 商品一覧画面へ遷移
        $response = $this->get('/');
        $products = $response->viewData('products');
        $product = $products->firstWhere('id', $itemId);

        // テスト対象商品の横にsoldが表示されているか確認
        $response->assertSeeInOrder([$product->product_name, 'sold'], false);

    }


    public function test_purchase_mypage() // 購入済み一覧テスト
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

        // テスト対象商品idを設定
        $itemId = 3;

        // 購入画面へ遷移
        $response = $this->get(route('purchase.index', ['item_id' => $itemId]));
        $product = $response->viewData('product');

        // 購入操作
        $response = $this->post(route('purchase.checkout',  ['item_id' => $product->id]),[
            'amount' => (int) $product->price,
            'payment_method' => 'card'
        ]);

        // マイページの購入した商品一覧へ遷移
        $response = $this->get(route('mypage.index', ['page' => 'buy']));
        $products = $response->viewData('buyProducts');

        // テスト対象商品のデータが取得できているか確認
        $this->assertTrue($products->contains('id', $itemId));
    }
}
