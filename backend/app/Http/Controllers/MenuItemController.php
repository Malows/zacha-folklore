<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Models\MenuItem;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MenuItem::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuItemRequest  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuItemRequest $request): MenuItem
    {
        return MenuItem::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(MenuItem $menuItem): MenuItem
    {
        $menuItem->load('section');
        
        return $menuItem;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuItemRequest  $request
     * @param  \App\Models\MenuItem  $menuItem
     * 
     * @return \Illuminate\Http\Response
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
     * @param  \App\Models\MenuItem  $menuItem
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuItem $menuItem): MenuItem
    {
        $menuItem->delete();
        
        return $menuItem;
    }
}
