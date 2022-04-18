<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $reservation = new Reservation($request->all());

        $reservation->uuid = Str::uuid();

        $disk = Storage::disk('reservations');
        $name = $reservation->uuid . '.svg';
        $route = route('reservations.show_uuid', $reservation->uuid);

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
