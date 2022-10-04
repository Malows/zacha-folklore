<?php

namespace Tests\Feature\Http\Controllers;

use App\Domain\EventDomain;
use App\Models\Event;
use App\Models\Reservation;
use Database\Seeders\EventSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class EventDomainTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group domain
     */
    public function test_deactivate_other_events()
    {
        $this->seed(EventSeeder::class);

        Event::query()->update(['is_active' => false]);

        $events = Event::all();
        $first = $events->first();
        $last = $events->last();

        $first->is_active = true;
        $first->save();

        EventDomain::deactivateOtherEvents($last);

        $first->refresh();

        $this->assertFalse($first->is_active);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group domain
     */
    public function test_try_to_get_active_event_with_actives()
    {
        $this->seed(EventSeeder::class);

        Event::query()->update(['is_active' => false]);

        $first = Event::query()->first();

        $first->is_active = true;
        $first->event_day = Carbon::tomorrow();
        $first->save();

        $active = EventDomain::tryToGetActiveEvent();

        $this->assertEquals($first->id, $active->id);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group domain
     */
    public function test_try_to_get_active_event_without_actives()
    {
        $this->seed(EventSeeder::class);

        Event::query()->update([
            'is_active' => false,
            'event_day' => Carbon::yesterday(),
        ]);

        $first = Event::query()->first();

        $first->event_day = Carbon::tomorrow();
        $first->save();

        $active = EventDomain::tryToGetActiveEvent();

        $this->assertEquals($first->id, $active->id);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group domain
     */
    public function test_try_to_get_active_event_invalid()
    {
        $this->seed(EventSeeder::class);

        Event::query()->update([
            'is_active' => false,
            'event_day' => Carbon::yesterday(),
        ]);

        $active = EventDomain::tryToGetActiveEvent();

        $this->assertNull($active);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group domain
     */
    public function test_add_reservation()
    {
        $this->seed(EventSeeder::class);

        $event = Event::query()->first();

        $old_amount = $event->reserved_tickets;
        $old_amount_paid = $event->pre_paid_reserved_tickets;

        $reservation = Reservation::factory()->make(['amount' => 1]);

        EventDomain::addReservation($event, $reservation);

        $event->refresh();

        $this->assertEquals($event->reserved_tickets, $old_amount + 1);
        $this->assertEquals($event->pre_paid_reserved_tickets, $old_amount_paid);

        $reservation->is_paid = true;

        EventDomain::addReservation($event, $reservation);

        $event->refresh();

        $this->assertEquals($event->reserved_tickets, $old_amount + 2);
        $this->assertEquals($event->pre_paid_reserved_tickets, $old_amount_paid + 1);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group domain
     */
    public function test_make_reservation_unpaid()
    {
        $this->seed(EventSeeder::class);

        $event = Event::query()->first();

        $old_amount_paid = $event->pre_paid_reserved_tickets;

        $reservation = Reservation::factory()->make(['amount' => 1]);

        EventDomain::makeReservationUnpaid($event, $reservation);

        $event->refresh();

        $this->assertEquals($event->pre_paid_reserved_tickets, $old_amount_paid - 1);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @group events
     * @group domain
     */
    public function test_update_reservations_amounts()
    {
        $event = Event::factory()->create();

        $event = EventDomain::updateReservationsAmounts($event);

        $this->assertEquals(0, $event->reserved_tickets);
        $this->assertEquals(0, $event->pre_paid_reserved_tickets);

        Reservation::factory()->create(['event_id' => $event->id]);

        Reservation::factory()->paid()->create(['event_id' => $event->id]);

        $event = EventDomain::updateReservationsAmounts($event);

        $this->assertGreaterThan(0, $event->reserved_tickets);
        $this->assertGreaterThan(0, $event->pre_paid_reserved_tickets);
    }
}
