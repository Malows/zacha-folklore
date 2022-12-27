<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = $this->getUsers();

        if (DB::table('users')->count() < count($users)) {
            foreach ($users as $user) {
                $this->checkOrCreateUser($user);
            }

            $this->assignRoles();
        }
    }

    /**
     * Provide a list of user
     *
     * @return arrray
     */
    protected function getUsers()
    {
        return App::environment('testing')
            ? [
                [ 'name' => 'admin', 'email' => 'admin@email.com', 'password' => Hash::make('admin') ],
                [ 'name' => 'manager', 'email' => 'manager@email.com', 'password' => Hash::make('manager') ],
                [ 'name' => 'ticket', 'email' => 'ticket@email.com', 'password' => Hash::make('ticket') ],
            ]
            : [
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

        foreach ($users as $user) {
            $role = match ($user->name) {
                env('ADMIN_USER_NAME'), 'admin' => $roles[0],
                env('COMMON_USER_NAME'), 'manager' => $roles[1],
                default => $roles[2],
            };

            $user->assignRole($role);
        }
    }
}
