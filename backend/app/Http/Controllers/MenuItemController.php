<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection<int, MenuItem>
     */
    public function index()
    {
        return MenuItem::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMenuItemRequest  $request
     * @return MenuItem
     */
    public function store(StoreMenuItemRequest $request): MenuItem
    {
        return MenuItem::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  MenuItem  $menuItem
     * @return MenuItem
     */
    public function show(MenuItem $menuItem): MenuItem
    {
        $menuItem->load('section');

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
