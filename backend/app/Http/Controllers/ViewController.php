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
        $sections = MenuSection::query()
            ->orderBy('order')
            ->with('items')
            ->get();

        return View::make('menu', ['sections' => $sections]);
    }
}
