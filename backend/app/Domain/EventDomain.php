<?php

namespace App\Domain;

use App\Models\Event;
use App\Models\Reservation;

class EventDomain
{
    public static function addReservation(Event $event, Reservation $reservation)
    {
        $event->reserved_tickets += $reservation->amount;

        if ($reservation->is_paid) {
            $event->pre_paid_reserved_tickets += $reservation->amount;
        }

        $event->save();
    }

    public static function makeReservationUnpaid(Event $event, Reservation $reservation)
    {
        $event->pre_paid_reserved_tickets -= $reservation->amount;

        $event->save();
    }

    public static function tryToGetActiveEvent()
    {
        $event = Event::active()->first();

        if ($event) {
            return $event;
        }

        $event = Event::nextEvent()->first();

        if ($event) {
            Event::query()->update([ 'is_active' => false ]);

            $event->is_active = true;

            $event->save();

            return $event;
        }

        return null;
    }

    public static function updateReservationsAmounts(Event $event)
    {
        $reservations = $event->reservations()->get();

        $event->reserved_tickets = $reservations->sum('amount');
        $event->pre_paid_reserved_tickets = $reservations
            ->sum(fn ($reservation) => $reservation->is_paid ? $reservation->amount : 0);

        $event->save();

        return $event;
    }
}
