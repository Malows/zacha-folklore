<?php

namespace App\Http\Controllers;

use App\Domain\EventDomain;
use App\Http\Requests\EventRequests\AddTicketsRequest;
use App\Http\Requests\EventRequests\CopyMenuRequest;
use App\Http\Requests\EventRequests\StoreRequest;
use App\Http\Requests\EventRequests\UpdateRequest;
use App\Models\Event;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection<int, Event>
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
            EventDomain::deactivateOtherEvents($event);
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

    /**
     * Display a listing of the resource.
     *
     * @param  Event  $event
     * @return Collection<int, MenuItem>
     */
    public function menuItems(Event $event)
    {
        return $event->menuItems()->get();
    }

    /**
     * Get the events that have menu sections
     *
     * @return Collection<int, Event>
     */
    public function withMenu()
    {
        return Event::query()
            ->has('menuSections')
            ->orderBy('event_day')
            ->get();
    }

    /**
     * Copy the menu from one event to another
     *
     * @param  CopyMenuRequest  $request
     * @return Event
     */
    public function copyMenu(CopyMenuRequest $request): Event
    {
        $from = Event::query()->with('menuSections.menuItems')->find($request->from);

        $to = Event::query()->find($request->to);

        foreach ($from->menuSections as $section) {
            $items = $section->menuItems->only(['name', 'price'])->toArray();

            $model = $to->menuSections()->create($section->toArray());

            $model->menuItems()->createMany($items);
        }

        $to->load('menuSections.menuItems');

        return $to;
    }
}
