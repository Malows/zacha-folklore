<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Models\MenuItem;
use App\Models\MenuSection;
use Illuminate\Database\Eloquent\Collection;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  MenuSection  $menuSection
     * @return Collection<int, MenuItem>
     */
    public function index(MenuSection $menuSection)
    {
        return $menuSection->menuItems()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMenuItemRequest  $request
     * @param  MenuSection  $menuSection
     * @return MenuItem
     */
    public function store(StoreMenuItemRequest $request, MenuSection $menuSection): MenuItem
    {
        return $menuSection->menuItems()->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  MenuItem  $menuItem
     * @return MenuItem
     */
    public function show(MenuItem $menuItem): MenuItem
    {
        $menuItem->load('menu_section');

        return $menuItem;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMenuItemRequest  $request
     * @param  MenuItem  $menuItem
     * @return MenuItem
     */
    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem): MenuItem
    {
        $menuItem
            ->fill($request->all())
            ->save();

        return $menuItem;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MenuItem  $menuItem
     * @return MenuItem
     */
    public function destroy(MenuItem $menuItem): MenuItem
    {
        $menuItem->delete();

        return $menuItem;
    }
}
