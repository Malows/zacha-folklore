<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\MenuSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class MenuSectionSeeder extends Seeder
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

        $event = Event::query()->get()->isEmpty()
            ? Event::factory()->create()
            : Event::first();

        MenuSection::factory()
            ->for($event)
            ->count(10)
            ->create();
    }
}
