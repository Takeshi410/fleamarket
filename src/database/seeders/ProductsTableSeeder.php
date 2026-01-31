<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
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
            'image_path' => 'products/product_1.jpg',
            'condition_id' => 1,
            'price' => 15000,
            'user_id' => 1,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'HDD',
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image_path' => 'products/product_2.jpg',
            'condition_id' => 2,
            'price' => 5000,
            'user_id' => 1,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => '玉ねぎ3束',
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'image_path' => 'products/product_3.jpg',
            'condition_id' => 3,
            'price' => 300,
            'user_id' => 2,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => '革靴',
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
            'image_path' => 'products/product_4.jpg',
            'condition_id' => 4,
            'price' => 4000,
            'user_id' => 2,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'ノートPC',
            'brand' => '',
            'description' => '高性能なノートパソコン',
            'image_path' => 'products/product_5.jpg',
            'condition_id' => 1,
            'price' => 45000,
            'user_id' => 3,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'マイク',
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'image_path' => 'products/product_6.jpg',
            'condition_id' => 2,
            'price' => 8000,
            'user_id' => 3,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'ショルダーバッグ',
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'image_path' => 'products/product_7.jpg',
            'condition_id' => 3,
            'price' => 3500,
            'user_id' => 4,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'タンブラー',
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'image_path' => 'products/product_8.jpg',
            'condition_id' => 4,
            'price' => 500,
            'user_id' => 4,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'コーヒーミル',
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'image_path' => 'products/product_9.jpg',
            'condition_id' => 1,
            'price' => 4000,
            'user_id' => 5,
        ];
        DB::table('products')->insert($param);

        $param = [
            'product_name' => 'メイクセット',
            'brand' => '',
            'description' => '便利なメイクアップセット',
            'image_path' => 'products/product_10.jpg',
            'condition_id' => 2,
            'price' => 2500,
            'user_id' => 5,
        ];
        DB::table('products')->insert($param);

    }
}
