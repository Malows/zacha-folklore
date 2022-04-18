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

Route::middleware('auth:api')->group(function () {
    Route::prefix('/user')->controller(ProfileController::class)->group(function () {
        Route::get('', 'show');
        Route::post('', 'update');
        Route::post('/password', 'password');
    });

    Route::apiResources([
        'menu_items' => MenuItemController::class,
        'menu_sections' => MenuSectionController::class,
        'reservations' => ReservationController::class,
        'users' => UserController::class,
    ]);

    Route::get('/reservations/uuid/{reservation:uuid}', [ReservationController::class, 'show'])
        ->name('reservations.show_uuid');
});
