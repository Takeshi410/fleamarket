<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ProductCategoryTableSeeder;

class CommentTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_comment() // コメント追加テスト
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

        $response = $this->get('/item/6');
        $product = $response->viewData('product');
        $beforeCount = $product->comments_count;

        // コメント送信
        $text = 'テストメッセージ';
        $response = $this->post(route('item.comment.store', ['item_id' => $product->id]), [
            'comment' => $text,
        ]);

        // コメントが追加されているか確認
        $this->assertDatabaseHas('Comments', [
            'user_id' => auth()->id(),
            'comment' => $text,
        ]);

        $response->assertRedirect();
        $response = $this->get('/item/' . $product->id);
        $product = $response->viewData('product');
        $afterCount = $product->comments_count;

        // コメント数が1増加しているか確認
        $this->assertSame($beforeCount + 1, $afterCount);
    }


    public function test_comment_guest() // 未ログインでのコメントテスト
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ProductCategoryTableSeeder::class);

        $response = $this->get('/item/6');
        $product = $response->viewData('product');
        $beforeCount = $product->comments_count;

        // 未ログインでコメント送信
        $text = 'テストメッセージ';
        $response = $this->post(route('item.comment.store', ['item_id' => $product->id]), [
            'comment' => $text,
        ]);

        $response->assertRedirect('/login');
    }


    public function test_comment_required_error() // コメント未入力エラーテスト
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

        $response = $this->get('/item/6');
        $product = $response->viewData('product');
        $beforeCount = $product->comments_count;

        // 空欄でコメント送信
        $text = '';
        $response = $this->post(route('item.comment.store', ['item_id' => $product->id]), [
            'comment' => $text,
        ]);

        $response->assertStatus(302);

        // バリデーションエラー確認
        $response->assertSessionHasErrors(['comment' => 'コメントを入力してください']);
    }


    public function test_comment_max_error() // コメント文字数エラーテスト
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

        $response = $this->get('/item/6');
        $product = $response->viewData('product');
        $beforeCount = $product->comments_count;

        // 256文字でコメント送信
        $text = Str::repeat('あ', 256);
        $response = $this->post(route('item.comment.store', ['item_id' => $product->id]), [
            'comment' => $text,
        ]);

        $response->assertStatus(302);

        // バリデーションエラー確認
        $response->assertSessionHasErrors(['comment'=> 'コメントは255文字以内で入力してください']);
    }
}
