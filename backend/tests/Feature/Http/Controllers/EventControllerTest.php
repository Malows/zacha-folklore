<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Database\Seeders\EventSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventControllerTest extends TestCase
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
        $this->seed(EventSeeder::class);
        $this->seed(UserSeeder::class);

        $this
            ->actingAs(User::query()->first(), 'api')
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
        $this->seed(UserSeeder::class);

        $this->assertDatabaseCount('events', 0);

        $data = Event::factory()->make()->toArray();

        $this
            ->actingAs(User::query()->first(), 'api')
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
        $this->seed(EventSeeder::class);
        $this->seed(UserSeeder::class);

        $item = Event::first();

        $this
            ->actingAs(User::query()->first(), 'api')
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
        $this->seed(EventSeeder::class);
        $this->seed(UserSeeder::class);

        $item = Event::first();

        $data = $item->toArray();
        $data['name'] = 'TEST NAME';

        $this
            ->actingAs(User::query()->first(), 'api')
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
        $this->seed(EventSeeder::class);
        $this->seed(UserSeeder::class);

        $item = Event::first();

        $this
            ->actingAs(User::query()->first(), 'api')
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
}
