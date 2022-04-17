<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        Reservation::factory()->count(5)->create([
            'is_paid' => false,
            'is_used' => false,
        ]);

        Reservation::factory()->count(5)->create([
            'is_paid' => true,
            'is_used' => false,
        ]);

        Reservation::factory()->count(5)->create([
            'is_paid' => true,
            'is_used' => true,
        ]);
    }
}
