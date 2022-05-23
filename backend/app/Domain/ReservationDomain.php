<?php

namespace App\Domain;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationDomain
{
    static public function factory(Event $event, Reservation $reservation, $disk): Reservation
    {
        $uuid = Str::uuid();
        $route = route('reservations.show_uuid', $uuid);
        $name = $uuid . '.svg';

        $reservation->event_id = $event->id;
        $reservation->uuid = $uuid;

        $disk->put(
            $name,
            QrCode::format('svg')->size(500)->margin(1)->generate($route)
        );

        $reservation->qr_path = $name;
        $reservation->qr_url = $disk->url($name);
        $reservation->is_paid = false;
        $reservation->is_used = false;

        $reservation->save();

        return $reservation;
    }
}
