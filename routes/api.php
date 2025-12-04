<?php

use App\Http\Controllers\Api\LocationApiController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/

Route::get('/cities', [LocationApiController::class, 'getCities'])->name('api.cities');
Route::get('/locations', [LocationApiController::class, 'getLocations'])->name('api.locations');

?>