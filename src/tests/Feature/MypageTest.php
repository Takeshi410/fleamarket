<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\UsersTableSeeder;

class MypageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mypage() // マイページテスト
    {
        $this->seed(UsersTableSeeder::class);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->get('/mypage');
        $response->assertStatus(200);

        $user = $response->viewData('user');
        $sellProducts = $response->viewData('sellProducts');
        $buyProducts = $response->viewData('buyProducts');

        // プロフィール画像、ユーザー名の確認
        foreach (['avatar_path', 'username'] as $column) {
            $this->assertNotNull($user->$column);
        }

        // 出品済みとして取得しているデータがログインユーザーと一致していることを確認
        foreach ($sellProducts as $product) {
            $this->assertSame(auth()->id(), $product->user_id);
        }

        // ログインユーザーの購入済みデータをDBから取得
        $purchaseProductIds = \DB::table('purchases')
            ->where('user_id', $user->id)
            ->pluck('product_id')
            ->all();

        // 画面遷移で取得したデータに購入済みデータのpurdouct_idに含まれているか確認
        foreach ($purchaseProductIds as $id) {
            $this->assertTrue($buyProducts->contains('id', $id));
        }
    }
}
