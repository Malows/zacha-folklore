<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\MenuItem;
use App\Models\MenuSection;
use App\Models\User;
use Database\Seeders\MenuItemSeeder;
use Database\Seeders\MenuSectionSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuItemControllerTest extends BaseHttpCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group menu items
     * @group controllers
     */
    public function test_menu_items_index()
    {
        $users = $this->db();
        $this->seed(MenuSectionSeeder::class);
        $this->seed(MenuItemSeeder::class);

        $section = MenuSection::first();

        $this
            ->actingAs($users[0], 'api')
            ->getJson("api/menu_sections/{$section->id}/menu_items")
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'name',
                    'price',
                    'menu_section_id',
                ],
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group menu items
     * @group controllers
     */
    public function test_menu_items_store()
    {
        $users = $this->db();
        $this->seed(MenuSectionSeeder::class);

        $this->assertDatabaseCount('menu_items', 0);

        $section = MenuSection::first();

        $data = MenuItem::factory()->recycle($section)->make()->toArray();

        $this
            ->actingAs($users[0], 'api')
            ->postJson("api/menu_sections/{$section->id}/menu_items", $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'name',
                'price',
                'menu_section_id',
            ]);

        $this->assertDatabaseCount('menu_items', 1);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group menu items
     * @group controllers
     */
    public function test_menu_items_show()
    {
        $users = $this->db();
        $this->seed(MenuSectionSeeder::class);
        $this->seed(MenuItemSeeder::class);

        $item = MenuItem::first();

        $this
            ->actingAs($users[0], 'api')
            ->getJson("api/menu_items/{$item->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'price',
                'menu_section_id',
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group menu items
     * @group controllers
     */
    public function test_menu_items_update()
    {
        $users = $this->db();
        $this->seed(MenuSectionSeeder::class);
        $this->seed(MenuItemSeeder::class);

        $item = MenuItem::first();

        $data = $item->toArray();
        $data['name'] = 'TEST NAME';

        $this
            ->actingAs($users[0], 'api')
            ->putJson("api/menu_items/{$item->id}", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'price',
                'menu_section_id',
            ]);

        $this->assertDatabaseHas('menu_items', ['name' => 'TEST NAME']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group menu items
     * @group controllers
     */
    public function test_menu_items_delete()
    {
        $users = $this->db();
        $this->seed(MenuSectionSeeder::class);
        $this->seed(MenuItemSeeder::class);

        $item = MenuItem::first();

        $this
            ->actingAs($users[0], 'api')
            ->deleteJson("api/menu_items/{$item->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'price',
                'menu_section_id',
            ]);

        $this->assertDatabaseMissing('menu_items', ['id' => $item->id]);
    }
}
