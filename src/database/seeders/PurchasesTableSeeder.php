<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchasesTableSeeder extends Seeder
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
            'product_id' => 4,
        ];
        DB::table('purchases')->insert($param);

        $param = [
            'user_id' => 1,
            'product_id' => 9,
        ];
        DB::table('purchases')->insert($param);

        $param = [
            'user_id' => 2,
            'product_id' => 7,
        ];
        DB::table('purchases')->insert($param);
    }
}
