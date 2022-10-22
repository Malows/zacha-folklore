<?php

namespace App\Domain;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationDomain
{
    /**
     * Reservation factory
     *
     * @param  Reservation  $reservation
     * @return Reservation
     */
    public static function factory(Event $event, Reservation $reservation, $disk): Reservation
    {
        $uuid = Str::uuid();
        $name = $uuid.'.png';

        $reservation->event_id = $event->id;
        $reservation->uuid = $uuid;

        $disk->put(
            $name,
            QrCode::format('png')
                ->size(500)
                ->margin(1)
                ->generate(ReservationDomain::getQrMessage($uuid))
        );

        $reservation->qr_path = $name;
        $reservation->qr_url = $disk->url($name);

        $reservation->save();

        EventDomain::updateReservationsAmounts($event);

        return $reservation;
    }

    /**
     * Generate the QR message for the QR code.
     *
     * @param  string  $uuid
     * @return string
     */
    private static function getQrMessage(string $uuid): string
    {
        return url("/app/#/qr/{$uuid}");
    }
}
