<?php

namespace App\Http\Controllers;

use App\Models\MenuSection;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\View;

class ViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection<int, User>
     */
    public function index()
    {
        $event = Event::query()->active()->first();

        if (!$event) {
            return View::make('missing_event_menu');
        }

        $sections = $event->menuSection()
            ->orderBy('order')
            ->with('menuItems')
            ->get();



        return View::make('menu', ['sections' => $sections]);
    }
}
