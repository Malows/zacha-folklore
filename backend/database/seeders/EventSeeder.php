<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class EventSeeder extends Seeder
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

        $now = Carbon::now();

        $monthAgo = $now->copy()->subMonth();
        $aWeekAhead = $now->copy()->addWeek();
        $threeMonthAhead = $now->copy()->addMonths(3);

        Event::factory()->create(['event_day' => $monthAgo]);
        Event::factory()->create(['event_day' => $aWeekAhead, 'is_active' => true, 'started_at' => null]);
        Event::factory()->create(['event_day' => $threeMonthAhead, 'started_at' => null]);
    }
}
