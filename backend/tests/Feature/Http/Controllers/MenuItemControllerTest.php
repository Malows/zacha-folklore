<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\MenuItem;
use App\Models\MenuSection;
use App\Models\User;
use Database\Seeders\MenuItemSeeder;
use Database\Seeders\MenuSectionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuItemControllerTest extends TestCase
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
        $this->seed(MenuSectionSeeder::class);
        $this->seed(MenuItemSeeder::class);
        $this->seed(UserSeeder::class);

        $this
            ->actingAs(User::query()->first(), 'api')
            ->getJson('api/menu_items')
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
        $this->seed(MenuSectionSeeder::class);
        $this->seed(UserSeeder::class);

        $this->assertDatabaseCount('menu_items', 0);

        $data = MenuItem::factory()->make()->toArray();
        $data['menu_section_id'] = MenuSection::query()->inRandomOrder()->first()->id;

        $this
            ->actingAs(User::query()->first(), 'api')
            ->postJson('api/menu_items', $data)
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
        $this->seed(MenuSectionSeeder::class);
        $this->seed(MenuItemSeeder::class);
        $this->seed(UserSeeder::class);

        $item = MenuItem::first();

        $this
            ->actingAs(User::query()->first(), 'api')
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
        $this->seed(MenuSectionSeeder::class);
        $this->seed(MenuItemSeeder::class);
        $this->seed(UserSeeder::class);

        $item = MenuItem::first();

        $data = $item->toArray();
        $data['name'] = 'TEST NAME';

        $this
            ->actingAs(User::query()->first(), 'api')
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
        $this->seed(MenuSectionSeeder::class);
        $this->seed(MenuItemSeeder::class);
        $this->seed(UserSeeder::class);

        $item = MenuItem::first();

        $this
            ->actingAs(User::query()->first(), 'api')
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
