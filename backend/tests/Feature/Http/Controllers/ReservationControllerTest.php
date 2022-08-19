<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\User;
use Database\Seeders\EventSeeder;
use Database\Seeders\ReservationSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
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
        $this->seed(UserSeeder::class);
        $this->seed(EventSeeder::class);
        $this->seed(ReservationSeeder::class);

        $this
            ->actingAs(User::query()->first(), 'api')
            ->getJson('api/reservations')
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
        $this->seed(UserSeeder::class);
        $this->seed(EventSeeder::class);

        $this->assertDatabaseCount('reservations', 0);

        $disk = Storage::fake('reservations');

        $activeEvent = Event::query()->active()->first();

        $data = Reservation::factory()->make()->toArray();

        $response = $this
            ->actingAs(User::query()->first(), 'api')
            ->postJson('api/reservations', $data);

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
                'event_id' => $activeEvent->id,
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
        $this->seed(UserSeeder::class);
        $this->seed(EventSeeder::class);
        $this->seed(ReservationSeeder::class);

        $reservation = Reservation::first();

        $this
            ->actingAs(User::query()->first(), 'api')
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
        $this->seed(UserSeeder::class);
        $this->seed(EventSeeder::class);
        $this->seed(ReservationSeeder::class);

        $reservation = Reservation::first();

        $data = $reservation->toArray();
        $data['name'] = 'TEST NAME';

        $this
            ->actingAs(User::query()->first(), 'api')
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
        $this->seed(UserSeeder::class);
        $this->seed(EventSeeder::class);
        $this->seed(ReservationSeeder::class);

        $reservation = Reservation::first();

        $this
            ->actingAs(User::query()->first(), 'api')
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
