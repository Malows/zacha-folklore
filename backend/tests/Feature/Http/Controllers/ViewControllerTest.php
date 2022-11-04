<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\MenuItem;
use App\Models\MenuSection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group views
     * @group controllers
     */
    public function test_index()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSeeText('Aún no tenemos un evento');

        // add an active event
        $event = Event::factory()->active()->create();

        $this->get('/')
            ->assertStatus(200)
            ->assertSeeText('No se terminó el menú del evento aún');

        // add menu section
        $section = MenuSection::factory()->recycle($event)->create(['name' => 'EXAMPLE']);

        MenuItem::factory()->recycle($section)->create(['name' => 'ITEM']);

        $this->get('/')
            ->assertStatus(200)
            ->assertSeeText('EXAMPLE')
            ->assertSeeText('ITEM');
    }
}
