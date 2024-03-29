<?php

namespace App\Http\Controllers;

use App\Domain\EventDomain;
use App\Domain\ReservationDomain;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Event  $event
     * @return Collection<int, Reservation>
     */
    public function index(Event $event)
    {
        return $event->reservations()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreReservationRequest  $request
     * @param  Event  $event
     * @return Reservation
     */
    public function store(StoreReservationRequest $request, Event $event): Reservation
    {
        $this->authorize('create', Reservation::class);

        // $event = EventDomain::tryToGetActiveEvent();

        // abort_unless($event, 422, 'Missing active event');

        return ReservationDomain::factory(
            $event,
            new Reservation($request->all()),
            Storage::disk('reservations')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  Reservation  $reservation
     * @return Reservation
     */
    public function show(Reservation $reservation): Reservation
    {
        $reservation->load('event');

        return $reservation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateReservationRequest  $request
     * @param  Reservation  $reservation
     * @return Reservation
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation): Reservation
    {
        $this->authorize('update', Reservation::class);

        $event = $reservation->event()->first();

        EventDomain::updateReservationsAmounts($event);

        $reservation
            ->fill($request->all())
            ->save();

        return $reservation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Reservation  $reservation
     * @return Reservation
     */
    public function destroy(Reservation $reservation): Reservation
    {
        $this->authorize('delete', Reservation::class);

        $reservation->delete();

        return $reservation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Reservation  $reservation
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(Reservation $reservation): mixed
    {
        return Storage::disk('reservations')->download($reservation->get('qr_path'));
    }
}
