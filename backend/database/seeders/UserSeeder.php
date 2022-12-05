<?php

namespace Database\Seeders;

use App\Models\User;
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

        $isTest = App::environment('testing');

        $userAmounts = $isTest ? 3 : 2;

        if ($isTest) {
            $user[] = [
                'name' => 'ticket',
                'email' => 'ticket@email.com',
                'password' => Hash::make('ticket'),
            ];
        }

        if (DB::table('users')->count() < $userAmounts) {
            foreach ($users as $user) {
                $this->checkOrCreateUser($user);
            }

            $this->assignRoles();
        }
    }


    /**
     * Check if the user exist or create it
     *
     * @param  array $user
     * @return void
     */
    private function checkOrCreateUser($user)
    {
        $fetched = DB::table('users')->where('email', $user['email'])->first();

        if (! $fetched) {
            DB::table('users')->insert($user);
        }
    }

    /**
     * Assign roles to the users
     *
     * @return void
     */
    private function assignRoles() {
        $users = User::all();

        $roles = [
            Role::findByName('admin', 'api'),
            Role::findByName('manager', 'api'),
            Role::findByName('ticket controller', 'api'),
        ];

        foreach ($user as $user) {
            $role = match ($user->name) {
                env('ADMIN_USER_NAME') => $roles[0],
                env('COMMON_USER_NAME') => $roles[1],
                default => $roles[2],
            };

            $user->assignRole($role);
        }
    }
}
