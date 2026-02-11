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

class AddressTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_address() // 住所変更テスト
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

        // 検証用住所
        $postcode = '0608588';
        $address = '札幌市中央区北3条西6丁目';
        $building = '札幌ビル1F';

        // 購入画面へ遷移
        $response = $this->get(route('purchase.index', ['item_id' => $itemId]));
        $addressData = $response->viewData('addressData');

        // 検証用住所と相違していることを確認
        $this->assertNotSame($postcode, $addressData->postcode);
        $this->assertNotSame($postcode, $addressData->address);
        $this->assertNotSame($postcode, $addressData->building);

        // 住所変更操作
        $response = $this->patch(route('purchase.address.update', ['item_id' => $itemId]),[
            'postcode' => $postcode,
            'address' => $address,
            'building' => $building,
        ]);

        $response->assertRedirect();

        // 再度購入画面へ遷移
        $response = $this->get(route('purchase.index', ['item_id' => $itemId]));
        $addressData = $response->viewData('addressData');

        // 検証用住所と一致していることを確認
        $this->assertSame($postcode, $addressData->postcode);
        $this->assertSame($address, $addressData->address);
        $this->assertSame($building, $addressData->building);
    }


    public function test_address_data() // 変更後住所のデータテスト
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

        // 検証用住所
        $postcode = '0608588';
        $address = '札幌市中央区北3条西6丁目';
        $building = '札幌ビル1F';

        // 住所変更操作
        $response = $this->patch(route('purchase.address.update', ['item_id' => $itemId]),[
            'postcode' => $postcode,
            'address' => $address,
            'building' => $building,
        ]);

        // product_idとuser_idが紐づけられた住所変更後のデータを取得
        $addressDate = \DB::table('shipping_addresses')->where('product_id', $itemId)->where('user_id', auth()->id())->first();

        // 住所変更後のデータが取得できているか確認
        $this->assertNotNull($addressDate);
    }
}
