<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\UsersTableSeeder;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_profile() // プロフィール画面テスト
    {
        $this->seed(UsersTableSeeder::class);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // プロフィール編集画面へ遷移
        $response = $this->get(route('mypage.profile', ['from' => 'mypage']));
        $response->assertStatus(200);

        $user = $response->viewData('user');

        // プロフィール画像、ユーザー名、郵便番号、住所、建物名を取得できているか確認
        foreach (['avatar_path', 'username', 'postcode', 'address', 'building'] as $column) {
            $this->assertNotNull($user->$column);
        }
    }
}
