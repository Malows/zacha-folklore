<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BaseHttpCase extends TestCase
{
    use RefreshDatabase;

    protected function db()
    {
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(UserSeeder::class);

        $users = User::query()->orderBy('name')->get();

        return $users;
    }
}
