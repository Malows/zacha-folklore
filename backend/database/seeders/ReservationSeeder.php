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

        foreach (Event::query()->active()->get() as $event) {
            Reservation::factory()
                ->for($event)
                ->count(5)
                ->create();

            Reservation::factory()
                ->for($event)
                ->count(5)
                ->paid()
                ->create();

            Reservation::factory()
                ->for($event)
                ->count(5)
                ->paid()
                ->used()
                ->create();
        }
    }
}
