<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => env('ADMIN_USER_NAME'),
                'email' => env('ADMIN_USER_EMAIL'),
                'password' => Hash::make(env('ADMIN_USER_PASSWORD')),
            ],
            [
                'name' => env('COMMON_USER_NAME'),
                'email' => env('COMMON_USER_EMAIL'),
                'password' => Hash::make(env('COMMON_USER_PASSWORD')),
            ],
        ];

        if (DB::table('users')->count() < 2) {
            foreach ($users as $user) {
                $this->checkOrCreateUser($user);
            }
        }
    }

    private function checkOrCreateUser($user)
    {
        $fetched = DB::table('users')->where('email', $user['email'])->first();

        if (!$fetched) {
            DB::table('users')->insert($user);
        }
    }
}
