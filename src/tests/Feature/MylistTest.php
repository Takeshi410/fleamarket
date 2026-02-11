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
use Database\Seeders\PurchasesTableSeeder;

class MylistTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mylist_index() // マイリスト一覧テスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->seed(likesTableSeeder::class);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->get('/?tab=mylist');
        $user = auth()->id();
        $products = $response->viewData('products');

        // likesテーブルからログインユーザーが「いいね」している商品のIDを取得
        $likedIds = \DB::table('likes')
        ->where('user_id', $user)
        ->pluck('product_id')
        ->all();

        // 取得されているproductsのidがlikesテーブルから取得できているか判定
        foreach ($products as $product) {
            $this->assertContains($product->id, $likedIds);
        }
    }

    public function test_mylist_sold() // マイリスト一覧購入済テスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->seed(likesTableSeeder::class);
        $this->seed(PurchasesTableSeeder::class);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->get('/?tab=mylist');
        $user = auth()->id();
        $products = $response->viewData('products');

        // 購入済み商品の商品名を取得
        $purchasedNames = \DB::table('purchases')
        ->join('products', 'purchases.product_id', '=', 'products.id')
        ->whereIn('products.id', $products->pluck('id'))
        ->pluck('products.product_name');

        // 取得した商品名を使い「商品名 → sold」で表示される箇所があるか判定
        foreach ($purchasedNames as $name) {
            $response->assertSeeInOrder([$name, 'sold'], false);
        }
    }

    public function test_mylist_index_logout() // ログアウト状態のマイリスト一覧テスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->seed(likesTableSeeder::class);

        $response = $this->get('/?tab=mylist');

        $products = $response->viewData('products');

        // 商品のデータが1件も取得できていないか判定
        $products = $response->viewData('products');
        $this->assertCount(0, $products);
    }
}

