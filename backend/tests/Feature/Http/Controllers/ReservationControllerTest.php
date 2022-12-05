<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use Database\Seeders\EventSeeder;
use Database\Seeders\ReservationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReservationControllerTest extends BaseHttpCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group reservations
     * @group controllers
     */
    public function test_reservations_index()
    {
        $users = $this->db();

        $this->seed(EventSeeder::class);
        $this->seed(ReservationSeeder::class);

        $event = Event::first();

        $this
            ->actingAs($users[0], 'api')
            ->getJson("api/events/{$event->id}/reservations")
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'name',
                    'last_name',
                    'amount',
                    'uuid',
                    'qr_path',
                    'qr_url',
                    'email',
                    'phone',
                    'is_paid',
                    'is_used',
                    'event_id',
                ],
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group reservations
     * @group controllers
     */
    public function test_reservations_store()
    {
        $users = $this->db();

        $this->seed(EventSeeder::class);

        $this->assertDatabaseCount('reservations', 0);

        $disk = Storage::fake('reservations');

        $event = Event::query()->active()->first();

        $data = Reservation::factory()->recycle($event)->make()->toArray();

        $response = $this
            ->actingAs($users[0], 'api')
            ->postJson("api/events/{$event->id}/reservations", $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'name',
                'last_name',
                'amount',
                'uuid',
                'qr_path',
                'qr_url',
                'email',
                'phone',
                // 'is_paid',
                // 'is_used',
                'event_id',
            ])
            ->assertJson([
                'event_id' => $event->id,
            ]);

        $uuid = $response->json('qr_path');

        $this->assertDatabaseCount('reservations', 1);
        $disk->assertExists($uuid);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group reservations
     * @group controllers
     */
    public function test_reservations_show()
    {
        $users = $this->db();

        $this->seed(EventSeeder::class);
        $this->seed(ReservationSeeder::class);

        $reservation = Reservation::first();

        $this
            ->actingAs($users[0], 'api')
            ->getJson("api/reservations/{$reservation->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'last_name',
                'amount',
                'uuid',
                'qr_path',
                'qr_url',
                'email',
                'phone',
                'is_paid',
                'is_used',
                'event_id',
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group reservations
     * @group controllers
     */
    public function test_reservations_update()
    {
        $users = $this->db();

        $this->seed(EventSeeder::class);
        $this->seed(ReservationSeeder::class);

        $reservation = Reservation::first();

        $data = $reservation->toArray();
        $data['name'] = 'TEST NAME';

        $this
            ->actingAs($users[0], 'api')
            ->putJson("api/reservations/{$reservation->id}", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'last_name',
                'amount',
                'uuid',
                'qr_path',
                'qr_url',
                'email',
                'phone',
                'is_paid',
                'is_used',
                'event_id',
            ]);

        $this->assertDatabaseHas('reservations', ['name' => 'TEST NAME']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group reservations
     * @group controllers
     */
    public function test_reservations_delete()
    {
        $users = $this->db();

        $this->seed(EventSeeder::class);
        $this->seed(ReservationSeeder::class);

        $reservation = Reservation::first();

        $this
            ->actingAs($users[0], 'api')
            ->deleteJson("api/reservations/{$reservation->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'last_name',
                'amount',
                'uuid',
                'qr_path',
                'qr_url',
                'email',
                'phone',
                'is_paid',
                'is_used',
                'event_id',
            ]);

        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id, 'deleted_at' => null]);
    }
}
