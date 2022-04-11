<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuSectionRequest;
use App\Http\Requests\UpdateMenuSectionRequest;
use App\Models\MenuSection;

class MenuSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MenuSection::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuSectionRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuSectionRequest $request): MenuSection
    {
        return MenuSection::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuSection  $menuSection
     *
     * @return \Illuminate\Http\Response
     */
    public function show(MenuSection $menuSection): MenuSection
    {
        $menuSection->load('items');

        return $menuSection;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuSectionRequest  $request
     * @param  \App\Models\MenuSection  $menuSection
     *
     * @return \Illuminate\Http\Response
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
     * @param  \App\Models\MenuSection  $menuSection
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuSection $menuSection): MenuSection
    {
        $menuSection->delete();

        return $menuSection;
    }
}
