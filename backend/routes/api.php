<?php

use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\MenuSectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ProfileController::class, 'show']);
    Route::post('/user', [ProfileController::class, 'update']);
    Route::post('/user/password', [ProfileController::class, 'password']);

    Route::apiResources([
        'menu_items' => MenuItemController::class,
        'menu_sections' => MenuSectionController::class,
        'reservations' => ReservationController::class,
        'users' => UserController::class,
    ]);
});
