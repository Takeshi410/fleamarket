<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'product_id' => 3,

        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 1,
            'product_id' => 5,

        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 1,
            'product_id' => 9,

        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 2,
            'product_id' => 6,

        ];

        DB::table('likes')->insert($param);
        $param = [
            'user_id' => 2,
            'product_id' => 7,

        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 2,
            'product_id' => 8,

        ];
        DB::table('likes')->insert($param);
    }
}
