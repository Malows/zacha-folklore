<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends BaseHttpCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group users
     * @group controllers
     */
    public function test_users_index()
    {
        $users = $this->db();

        $this
            ->actingAs($users[0], 'api')
            ->getJson('api/users')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'name',
                    'email',
                ],
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group users
     * @group controllers
     */
    public function test_users_store()
    {
        $users = $this->db();

        $USERS_AMOUNT = 3; // admin, manager and ticket controller

        $this->assertDatabaseCount('users', $USERS_AMOUNT);

        $data = User::factory()->make()->toArray();
        $data['password'] = 'password';
        $data['password_confirmation'] = 'password';
        $data['roles'] = ['admin'];

        $this
            ->actingAs($users[0], 'api')
            ->postJson('api/users', $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
            ]);

        $this->assertDatabaseCount('users', $USERS_AMOUNT + 1);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group users
     * @group controllers
     */
    public function test_users_show()
    {
        $users = $this->db();

        $user = $users[0];

        $this
            ->actingAs($user, 'api')
            ->getJson("api/users/{$user->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group users
     * @group controllers
     */
    public function test_users_update()
    {
        $users = $this->db();

        $user = $users[0];

        $data = $user->toArray();
        $data['name'] = 'TEST NAME';
        $data['roles'] = ['admin'];

        $this
            ->actingAs($users[0], 'api')
            ->putJson("api/users/{$user->id}", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
            ]);

        $this->assertDatabaseHas('users', ['name' => 'TEST NAME']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group users
     * @group controllers
     */
    public function test_users_delete()
    {
        $users = $this->db();

        $user = $users[0];

        $this
            ->actingAs($users[0], 'api')
            ->deleteJson("api/users/{$user->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
            ]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
