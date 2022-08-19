<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group profile
     * @group controllers
     */
    public function test_profile_show()
    {
        $this->seed(UserSeeder::class);

        $this
            ->actingAs(User::first(), 'api')
            ->getJson('api/user')
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'email',
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group profile
     * @group controllers
     */
    public function test_profile_update()
    {
        $this->seed(UserSeeder::class);

        $user = User::first();

        $data = $user->toArray();
        $data['name'] = 'TEST NAME';

        $this
            ->actingAs($user, 'api')
            ->postJson('api/user', $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'email',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'TEST NAME',
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group profile
     * @group controllers
     */
    public function test_profile_password()
    {
        $this->seed(UserSeeder::class);

        $user = User::first();

        $oldPassword = $user->password;

        $data = [
            'password' => 'TEST PASSWORD',
            'password_confirmation' => 'TEST PASSWORD',
        ];

        $this
            ->actingAs($user, 'api')
            ->postJson('api/user/password', $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'email',
            ]);

        $user->refresh();

        $this->assertNotEquals($oldPassword, $user->password);
        $this->assertDatabaseHas('users', [
            'password' => $user->password,
        ]);
    }
}
