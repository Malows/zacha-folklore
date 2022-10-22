<?php

use App\Http\Controllers\EventController;
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

Route::middleware('auth:api')->group(function () {
    Route::prefix('/user')->controller(ProfileController::class)->group(function () {
        Route::get('', 'show');
        Route::post('', 'update');
        Route::post('/password', 'password');
    });

    Route::apiResource('events', EventController::class);
    Route::apiResource('events.menu_sections', MenuSectionController::class)->shallow();
    Route::apiResource('events.reservations', ReservationController::class)->shallow();
    Route::apiResource('menu_sections.menu_items', MenuItemController::class)->shallow();
    Route::apiResource('users', UserController::class);
});

Route::get('/events/{event}/menu_items', [EventController::class, 'menuItems'])
    ->name('events.menu_items');

Route::get('/reservations/uuid/{reservation:uuid}', [ReservationController::class, 'show'])
    ->name('reservations.show_uuid');
