<?php

namespace App\Domain;

use App\Models\Event;
use App\Models\Reservation;

class EventDomain
{
    /**
     * Handle the addition of a reservation on the event data
     *
     * @param  Event  $event
     * @param  Reservation  $reservation
     */
    public static function addReservation(Event $event, Reservation $reservation)
    {
        $event->reserved_tickets += $reservation->amount;

        if ($reservation->is_paid) {
            $event->pre_paid_reserved_tickets += $reservation->amount;
        }

        $event->save();
    }

    /**
     * Update event data when the reservation turns to unpaid
     *
     * @param  Event  $event
     * @param  Reservation  $reservation
     */
    public static function makeReservationUnpaid(Event $event, Reservation $reservation)
    {
        $event->pre_paid_reserved_tickets -= $reservation->amount;

        $event->save();
    }

    /**
     * Try to get an active event or the next event
     *
     * @return Event | null
     */
    public static function tryToGetActiveEvent()
    {
        $event = Event::active()->first();

        if ($event) {
            return $event;
        }

        $event = Event::nextEvent()->first();

        if ($event) {
            Event::query()->update(['is_active' => false]);

            $event->is_active = true;

            $event->save();

            return $event;
        }

        return null;
    }

    /**
     * Update the computed data of reservation on the event
     *
     * @param  Event  $event
     * @return Event
     */
    public static function updateReservationsAmounts(Event $event): Event
    {
        $reservations = $event->reservations()->get();

        $event->reserved_tickets = $reservations->sum('amount');
        $event->pre_paid_reserved_tickets = $reservations
            ->sum(fn ($reservation) => $reservation->is_paid ? $reservation->amount : 0);

        $event->save();

        return $event;
    }

    /**
     * Turn every other event to inactive
     *
     * @param  Event  $event
     */
    public static function deactivateOtherEvents(Event $event)
    {
        Event::query()
            ->where('id', '!=', $event->id)
            ->where(['is_active' => true])
            ->update(['is_active' => false]);
    }
}
