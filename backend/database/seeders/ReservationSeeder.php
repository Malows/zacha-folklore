<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! App::environment('testing')) {
            return;
        }

        $event = Event::query()->active()->first();

        Reservation::factory()->count(5)->create([
            'is_paid' => false,
            'is_used' => false,
            'event_id' => $event->id,
        ]);

        Reservation::factory()->count(5)->create([
            'is_paid' => true,
            'is_used' => false,
            'event_id' => $event->id,
        ]);

        Reservation::factory()->count(5)->create([
            'is_paid' => true,
            'is_used' => true,
            'event_id' => $event->id,
        ]);
    }
}
