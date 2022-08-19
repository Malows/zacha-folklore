<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequests\AddTicketsRequest;
use App\Http\Requests\EventRequests\StoreRequest;
use App\Http\Requests\EventRequests\UpdateRequest;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Event::query()->orderBy('event_day')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return Event
     */
    public function store(StoreRequest $request): Event
    {
        return Event::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  Event  $event
     * @return Event
     */
    public function show(Event $event): Event
    {
        return $event;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Event  $event
     * @return Event
     */
    public function update(UpdateRequest $request, Event $event): Event
    {
        if ($request->has('is_active') && $request->get('is_active')) {
            Event::query()
                ->where(['is_active' => true])
                ->update(['is_active' => false]);
        }

        $event->fill($request->all())->save();

        return $event;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Event  $event
     * @return Event
     */
    public function destroy(Event $event): Event
    {
        $event->delete();

        return $event;
    }

    /**
     * Add common tickets to the specified resource.
     *
     * @param  AddTicketsRequest  $request
     * @param  Event  $event
     * @return Event
     */
    public function addCommonTickets(AddTicketsRequest $request, Event $event): Event
    {
        $event->common_tickets += $request->tickets;

        $event->save();

        return $event;
    }
}
