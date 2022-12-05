<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends BaseHttpCase
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
        $users = $this->db();

        $this
            ->actingAs($users[0], 'api')
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
        $users = $this->db();

        $user = $users[0];

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
        $users = $this->db();

        $user = $users[0];

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
