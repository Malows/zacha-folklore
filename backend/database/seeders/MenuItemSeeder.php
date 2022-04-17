<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\MenuSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class MenuItemSeeder extends Seeder
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

        foreach (MenuSection::cursor() as $section) {
            MenuItem::factory()->count(5)->create([
                'menu_section_id' => $section->id,
            ]);
        }
    }
}
