<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\MenuSection;
use App\Models\User;
use Database\Seeders\MenuSectionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuSectionControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group menu sections
     * @group controllers
     */
    public function test_menu_sections_index()
    {
        $this->seed(MenuSectionSeeder::class);
        $this->seed(UserSeeder::class);

        $this
            ->actingAs(User::query()->first(), 'api')
            ->getJson('api/menu_sections')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'name',
                    'order',
                ],
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group menu sections
     * @group controllers
     */
    public function test_menu_sections_store()
    {
        $this->seed(UserSeeder::class);

        $this->assertDatabaseCount('menu_sections', 0);

        $data = MenuSection::factory()->make()->toArray();

        $this
            ->actingAs(User::query()->first(), 'api')
            ->postJson('api/menu_sections', $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'name',
                'order',
            ]);

        $this->assertDatabaseCount('menu_sections', 1);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group menu sections
     * @group controllers
     */
    public function test_menu_sections_show()
    {
        $this->seed(MenuSectionSeeder::class);
        $this->seed(UserSeeder::class);

        $section = MenuSection::first();

        $this
            ->actingAs(User::query()->first(), 'api')
            ->getJson("api/menu_sections/{$section->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'order',
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group menu sections
     * @group controllers
     */
    public function test_menu_sections_update()
    {
        $this->seed(MenuSectionSeeder::class);
        $this->seed(UserSeeder::class);

        $section = MenuSection::first();

        $data = $section->toArray();
        $data['name'] = 'TEST NAME';

        $this
            ->actingAs(User::query()->first(), 'api')
            ->putJson("api/menu_sections/{$section->id}", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'order',
            ]);

        $this->assertDatabaseHas('menu_sections', ['name' => 'TEST NAME']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group menu sections
     * @group controllers
     */
    public function test_menu_sections_delete()
    {
        $this->seed(MenuSectionSeeder::class);
        $this->seed(UserSeeder::class);

        $section = MenuSection::first();

        $this
            ->actingAs(User::query()->first(), 'api')
            ->deleteJson("api/menu_sections/{$section->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'order',
            ]);

        $this->assertDatabaseMissing('menu_sections', ['id' => $section->id]);
    }
}
