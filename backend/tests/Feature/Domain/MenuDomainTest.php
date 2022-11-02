<?php

namespace Tests\Feature\Domain;

use App\Domain\MenuDomain;
use App\Models\Event;
use App\Models\MenuItem;
use App\Models\MenuSection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuDomainTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group menu sections
     * @group domain
     */
    public function test_copy_menu_from_event()
    {
        $from = Event::factory()->create();
        $to = Event::factory()->create();

        $item = MenuItem::factory()
            ->for(MenuSection::factory()->recycle($from)->create())
            ->create();

        $this->assertEquals(0, $to->menuSections()->count());
        $this->assertEquals(0, $to->menuItems()->count());

        $this->assertEquals(1, $from->menuSections()->count());
        $this->assertEquals(1, $from->menuItems()->count());

        MenuDomain::copyMenuFromEvent($from, $to);

        $this->assertEquals(1, $to->menuSections()->count());
        $this->assertEquals(1, $to->menuItems()->count());
    }
}
