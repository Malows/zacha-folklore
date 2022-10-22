<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuSectionRequest;
use App\Http\Requests\UpdateMenuSectionRequest;
use App\Models\Event;
use App\Models\MenuSection;
use Illuminate\Database\Eloquent\Collection;

class MenuSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *`
     *
     * @param  Event  $event
     * @return Collection<int, MenuSection>
     */
    public function index(Event $event)
    {
        return $event->menuSections()->with('menuItems')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMenuSectionRequest  $request
     * @param  Event  $event
     * @return MenuSection
     */
    public function store(StoreMenuSectionRequest $request, Event $event): MenuSection
    {
        return $event->menuSections()->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  MenuSection  $menuSection
     * @return MenuSection
     */
    public function show(MenuSection $menuSection): MenuSection
    {
        $menuSection->load('menuItems');

        return $menuSection;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMenuSectionRequest  $request
     * @param  MenuSection  $menuSection
     * @return MenuSection
     */
    public function update(UpdateMenuSectionRequest $request, MenuSection $menuSection): MenuSection
    {
        $menuSection
            ->fill($request->all())
            ->save();

        return $menuSection;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MenuSection  $menuSection
     * @return MenuSection
     */
    public function destroy(MenuSection $menuSection): MenuSection
    {
        $menuSection->delete();

        return $menuSection;
    }
}
