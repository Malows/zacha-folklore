<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\MenuSection;
use App\Models\User;
use Database\Seeders\MenuSectionSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuSectionControllerTest extends BaseHttpCase
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
        $users = $this->db();

        $this->seed(MenuSectionSeeder::class);

        $event = Event::first();

        $this
            ->actingAs($users[0], 'api')
            ->getJson("api/events/{$event->id}/menu_sections")
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
        $users = $this->db();

        $this->assertDatabaseCount('menu_sections', 0);

        $event = Event::factory()->create();

        $data = MenuSection::factory()->recycle($event)->make()->toArray();

        $this
            ->actingAs($users[0], 'api')
            ->postJson("api/events/{$event->id}/menu_sections", $data)
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
        $users = $this->db();

        $this->seed(MenuSectionSeeder::class);

        $section = MenuSection::first();

        $this
            ->actingAs($users[0], 'api')
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
        $users = $this->db();

        $this->seed(MenuSectionSeeder::class);

        $section = MenuSection::first();

        $data = $section->toArray();
        $data['name'] = 'TEST NAME';

        $this
            ->actingAs($users[0], 'api')
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
        $users = $this->db();

        $this->seed(MenuSectionSeeder::class);

        $section = MenuSection::first();

        $this
            ->actingAs($users[0], 'api')
            ->deleteJson("api/menu_sections/{$section->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'order',
            ]);

        $this->assertDatabaseMissing('menu_sections', ['id' => $section->id]);
    }
}
