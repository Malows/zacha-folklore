<?php

namespace App\Domain;

use App\Models\Event;
use App\Models\Reservation;

class EventDomain
{
    static public function addReservation(Event $event, Reservation $reservation) {
        $event->reserved_tickets += $reservation->amount;

        if ($reservation->is_paid) {
            $event->pre_paid_reserved_tickets += $reservation->amount;
        }

        $event->save();
    }

    static public function makeReservationUnpaid(Event $event, Reservation $reservation) {
        $event->pre_paid_reserved_tickets -= $reservation->amount;

        $event->save();
    }

    static public function tryToGetActiveEvent() {
        $event = Event::active()->first();

        if ($event) {
            return $event;
        }

        $event = Event::nextEvent()->first();

        if ($event) {
            Event::update([ 'is_active' => false ]);

            $event->is_active = true;

            $event->save();

            return $event;
        }

        return null;
    }
}
