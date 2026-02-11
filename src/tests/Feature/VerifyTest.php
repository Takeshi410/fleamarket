<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Tests\TestCase;

class VerifyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_verify_mail() // 認証メール送信テスト
    {
        Notification::fake();

        // 新規ユーザー登録
        $response = $this->post('/register', [
            'username' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = \App\Models\User::where('email', 'test@example.com')->first();

        // メール送信の確認
        Notification::assertSentTo($user, VerifyEmail::class);
    }


    public function test_verify_page() // メール認証誘導画面テスト
    {
        // 新規ユーザー登録
        $response = $this->post('/register', [
            'username' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // ユーザー登録後、プロフィール画面へリダイレクト
        $response->assertRedirect('/mypage/profile');

        // メール未認証により、メール認証誘導画面へ遷移することを確認
        $response = $this->get('/mypage/profile');
        $response->assertRedirect('/email/verify');
    }


    public function test_verify() // 認証テスト
    {
        Notification::fake();

        // 新規ユーザー登録
        $response = $this->post('/register', [
            'username' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = \App\Models\User::where('email', 'test@example.com')->first();

        // 認証メールのリンクを取得
        Notification::assertSentTo($user, VerifyEmail::class, function ($notification, $channels) use ($user, &$verifyUrl) {
            $mail = $notification->toMail($user);
            $verifyUrl = $mail->actionUrl; // 認証リンクを取得

            return true;
        });

        // 認証リンクへアクセスし、プロフィール画面にリダイレクトされる事を確認
        $verifyResponse = $this->actingAs($user)->get($verifyUrl);
        $response->assertRedirect('/mypage/profile');
    }

}
