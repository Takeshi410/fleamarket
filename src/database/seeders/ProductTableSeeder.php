<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'product_name' => '腕時計',
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'category_id' => 1,
            'file_name' => 'image_1.jpg',
            'condition_id' => 1,
            'price' => 15000,
            'user_id' => 1,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'HDD',
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'category_id' => 1,
            'file_name' => 'image_2.jpg',
            'condition_id' => 2,
            'price' => 5000,
            'user_id' => 1,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => '玉ねぎ3束',
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'category_id' => 1,
            'file_name' => 'image_3.jpg',
            'condition_id' => 3,
            'price' => 300,
            'user_id' => 1,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => '革靴',
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
            'category_id' => 1,
            'file_name' => 'image_4.jpg',
            'condition_id' => 4,
            'price' => 4000,
            'user_id' => 1,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'ノートPC',
            'brand' => '',
            'description' => '高性能なノートパソコン',
            'category_id' => 1,
            'file_name' => 'image_5.jpg',
            'condition_id' => 1,
            'price' => 45000,
            'user_id' => 1,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'マイク',
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'category_id' => 1,
            'file_name' => 'image_6.jpg',
            'condition_id' => 2,
            'price' => 8000,
            'user_id' => 1,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'ショルダーバッグ',
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'category_id' => 1,
            'file_name' => 'image_7.jpg',
            'condition_id' => 3,
            'price' => 3500,
            'user_id' => 1,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'タンブラー',
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'category_id' => 1,
            'file_name' => 'image_8.jpg',
            'condition_id' => 4,
            'price' => 500,
            'user_id' => 1,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'コーヒーミル',
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'category_id' => 1,
            'file_name' => 'image_9.jpg',
            'condition_id' => 1,
            'price' => 4000,
            'user_id' => 1,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'メイクセット',
            'brand' => '',
            'description' => '便利なメイクアップセット',
            'category_id' => 1,
            'file_name' => 'image_10.jpg',
            'condition_id' => 2,
            'price' => 2500,
            'user_id' => 1,
        ];
        DB::table('products')->insert($param);

    }
}
