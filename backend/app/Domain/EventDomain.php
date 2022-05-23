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
}
