<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\MenuItem;
use App\Models\MenuSection;
use App\Models\User;
use Database\Seeders\EventSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class EventControllerTest extends BaseHttpCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group controllers
     */
    public function test_events_index()
    {
        $users = $this->db();

        $this->seed(EventSeeder::class);

        $this
            ->actingAs($users[0], 'api')
            ->getJson('api/events')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'location',
                    'address',
                    'event_day',
                    'started_at',
                    'is_active',
                    // 'reserved_tickers',
                    'pre_paid_reserved_tickets',
                    'common_tickets',
                ],
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group controllers
     */
    public function test_events_store()
    {
        $users = $this->db();

        $this->assertDatabaseCount('events', 0);

        $data = Event::factory()->make()->toArray();

        $this
            ->actingAs($users[0], 'api')
            ->postJson('api/events', $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'location',
                'address',
                'event_day',
                'started_at',
                'is_active',
                // 'reserved_tickers',
                'pre_paid_reserved_tickets',
                'common_tickets',
            ]);

        $this->assertDatabaseCount('events', 1);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group controllers
     */
    public function test_events_show()
    {
        $users = $this->db();

        $this->seed(EventSeeder::class);

        $item = Event::first();

        $this
            ->actingAs($users[0], 'api')
            ->getJson("api/events/{$item->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'location',
                'address',
                'event_day',
                'started_at',
                'is_active',
                // 'reserved_tickers',
                'pre_paid_reserved_tickets',
                'common_tickets',
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group controllers
     */
    public function test_events_update()
    {
        $users = $this->db();

        $this->seed(EventSeeder::class);

        $item = Event::first();

        $data = $item->toArray();
        $data['name'] = 'TEST NAME';

        $this
            ->actingAs($users[0], 'api')
            ->putJson("api/events/{$item->id}", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'location',
                'address',
                'event_day',
                'started_at',
                'is_active',
                // 'reserved_tickers',
                'pre_paid_reserved_tickets',
                'common_tickets',
            ]);

        $this->assertDatabaseHas('events', ['name' => 'TEST NAME']);

        // check override of active event
        Event::query()->update(['is_active' => false]);
        $item->event_day = Carbon::tomorrow();
        $item->is_active = true;
        $item->save();

        $other = Event::query()->where('id', '!=', $item->id)->first();

        $this
            ->actingAs($users[0], 'api')
            ->putJson("api/events/{$other->id}", ['is_active' => true, 'event_day' => Carbon::tomorrow()])
            ->assertStatus(200);

        $item->refresh();
        $other->refresh();

        $this->assertFalse($item->is_active);
        $this->assertTrue($other->is_active);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group controllers
     */
    public function test_events_delete()
    {
        $users = $this->db();

        $this->seed(EventSeeder::class);

        $item = Event::first();

        $this
            ->actingAs($users[0], 'api')
            ->deleteJson("api/events/{$item->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'location',
                'address',
                'event_day',
                'started_at',
                'is_active',
                // 'reserved_tickers',
                'pre_paid_reserved_tickets',
                'common_tickets',
            ]);

        $this->assertNull(Event::find($item->id));
        $this->assertDatabaseHas('events', ['id' => $item->id]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group controllers
     */
    public function test_events_menu_items()
    {
        $users = $this->db();

        $this->seed(EventSeeder::class);

        $event = Event::first();
        $item = MenuItem::factory()
            ->for(MenuSection::factory()->recycle($event)->create())
            ->create();

        $this
            ->actingAs($users[0], 'api')
            ->getJson("api/events/{$event->id}/menu_items")
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
     * @group events
     * @group controllers
     */
    public function test_events_with_menu_sections()
    {
        $users = $this->db();

        $this->seed(EventSeeder::class);

        $event = Event::first();
        $item = MenuItem::factory()
            ->for(MenuSection::factory()->recycle($event)->create())
            ->create();

        // add event without menu sections
        Event::factory()->create();

        $response = $this
            ->actingAs($users[0], 'api')
            ->getJson('api/events_with_menu')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'location',
                    'address',
                    'event_day',
                    'started_at',
                    'is_active',
                    // 'reserved_tickers',
                    'pre_paid_reserved_tickets',
                    'common_tickets',
                ],
            ]);

        $this->assertCount(1, $response->json());
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group controllers
     */
    public function test_events_copy_menu()
    {
        $users = $this->db();

        $from = Event::factory()->create();
        $to = Event::factory()->create();

        $item = MenuItem::factory()
            ->for(MenuSection::factory()->recycle($from)->create())
            ->create();

        $response = $this
            ->actingAs($users[0], 'api')
            ->postJson('api/events_copy_menu', ['from' => $from->id, 'to' => $to->id])
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'location',
                'address',
                'event_day',
                'started_at',
                'is_active',
                // 'reserved_tickers',
                'pre_paid_reserved_tickets',
                'common_tickets',
            ]);

        $to->refresh();

        $this->assertEquals(1, $to->menuSections()->count());

        // Can't make a copy over a event that already have a menu
        $response = $this
            ->actingAs($users[0], 'api')
            ->postJson('api/events_copy_menu', ['from' => $from->id, 'to' => $to->id])
            ->assertStatus(400);
    }
}
