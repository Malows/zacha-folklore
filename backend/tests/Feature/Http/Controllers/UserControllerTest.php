<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
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
        $this->seed(UserSeeder::class);

        $this
            ->actingAs(User::query()->first(), 'api')
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
        $this->seed(UserSeeder::class);

        $this->assertDatabaseCount('users', 1);

        $data = User::factory()->make()->toArray();

        $this
            ->actingAs(User::query()->first(), 'api')
            ->postJson('api/users', $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
            ]);

        $this->assertDatabaseCount('users', 2);
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
        $this->seed(UserSeeder::class);

        $user = User::first();

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
        $this->seed(UserSeeder::class);

        $user = User::first();

        $this
            ->actingAs(User::query()->first(), 'api')
            ->putJson("api/users/{$user->id}", ['name' => 'TEST NAME'])
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
        $this->seed(UserSeeder::class);

        $user = User::first();

        $this
            ->actingAs(User::query()->first(), 'api')
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
