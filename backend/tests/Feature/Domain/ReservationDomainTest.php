<?php

namespace Tests\Feature\Http\Controllers;

use App\Domain\ReservationDomain;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReservationDomainTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group reservations
     * @group domain
     */
    public function test_factory()
    {
        $event = Event::factory()->active()->create();

        $reservation = Reservation::factory()->make(['event_id' => $event->id]);

        $disk = Storage::fake('reservations');

        $disk->assertDirectoryEmpty('');

        $reservation = ReservationDomain::factory($event, $reservation, $disk);

        $disk->assertExists($reservation->qr_path);
    }
}
