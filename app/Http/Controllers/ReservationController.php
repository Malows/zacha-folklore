<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reservation::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReservationRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReservationRequest $request): Reservation
    {
        $reservation = new Reservation($request->all());

        $reservation->setAttribute('uuid', Str::uuid());

        // generate qr code

        $reservation->save();

        return $reservation;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation): Reservation
    {
        return $reservation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReservationRequest  $request
     * @param  \App\Models\Reservation  $reservation
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation): Reservation
    {
        $reservation
            ->fill($request->all())
            ->save();

        return $reservation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation): Reservation
    {
        $reservation->delete();

        return $reservation;
    }
}
