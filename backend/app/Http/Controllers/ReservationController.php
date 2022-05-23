<?php

namespace App\Http\Controllers;

use App\Domain\EventDomain;
use App\Domain\ReservationDomain;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection<int, Reservation>
     */
    public function index()
    {
        return Reservation::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreReservationRequest  $request
     *
     * @return Reservation
     */
    public function store(StoreReservationRequest $request): Reservation
    {
        $event = EventDomain::tryToGetActiveEvent();

        if (!$event) {
            abort(404);
        }

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
     *
     * @return Reservation
     */
    public function show(Reservation $reservation): Reservation
    {
        return $reservation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateReservationRequest  $request
     * @param  Reservation  $reservation
     *
     * @return Reservation
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation): Reservation
    {
        $event = $reservation->event()->first();

        $reservation
            ->fill($request->all())
            ->save();

        return $reservation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Reservation  $reservation
     *
     * @return Reservation
     */
    public function destroy(Reservation $reservation): Reservation
    {
        $reservation->delete();

        return $reservation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Reservation  $reservation
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(Reservation $reservation): mixed
    {
        return Storage::disk('reservations')->download($reservation->qr_path);
    }
}
