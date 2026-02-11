<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
        'username' => 'test_user',
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
        'postcode' => '1638001',
        'address' => '東京都新宿区西新宿2-8-1',
        'building' => '新宿ビル1F',
        'avatar_path' => 'avatar/avatar_1.jpg',
        'email_verified_at' => Carbon::now(),
        ];
        DB::table('users')->insert($param);

        User::factory()->count(4)->create();
    }
}
