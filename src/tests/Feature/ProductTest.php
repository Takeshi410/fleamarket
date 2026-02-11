<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\PurchasesTableSeeder;

class ProductTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_product_index() // 商品一覧の全商品取得テスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);


        $response = $this->get('/');

        // DBの全商品名が画面に表示されているか確認
        foreach (Product::all() as $product) {
            $response->assertSee(e($product->product_name), false);
        }
    }


    public function test_product_sold() //商品一覧の購入済テスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->seed(PurchasesTableSeeder::class);

        $response = $this->get('/');

        // 購入済み商品の商品名を取得
        $purchasedNames = \DB::table('purchases')
        ->join('products', 'purchases.product_id', '=', 'products.id')
        ->pluck('products.product_name');

        // 取得した商品名を使い「商品名 → sold」で表示される箇所があるか判定
        foreach ($purchasedNames as $name) {
            $response->assertSeeInOrder([$name, 'sold'], false);
        }
    }


    public function test_product_login_user() // ログインユーザー出品商品非表示テスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->get('/');
        $user = auth()->id();

        // 取得されているproductsのデータにログインユーザーのidが含まれていないか判定
        $products = $response->viewData('products');
        foreach ($products as $product) {
            $this->assertNotSame($user, $product->user_id);
        }
    }
}