<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            'name' => '腕時計',
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなで座アインのメンズ腕時計',
            'imagepath' => 'img/product/000001_1.jpg',
        ];
    }
}
