<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\UsersTableSeeder;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_email_required() // メールアドレス未入力バリデーションテスト
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
            ]);

        $response->assertSessionDoesntHaveErrors(['password']);
    }


    public function test_password_required() // パスワード未入力バリデーションテスト
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
            ]);

        $response->assertSessionDoesntHaveErrors(['email']);
    }


    public function test_failed() // ログインエラーテスト
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->post('/login', [
            'email' => 'user@sample.co.jp',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
            ]);
    }


    public function test_login_success() // ログイン成功テスト
    {
        $this->seed(UsersTableSeeder::class);

        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionDoesntHaveErrors(['email', 'password']);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
