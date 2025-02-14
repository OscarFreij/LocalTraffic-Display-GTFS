<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/screen/{screen_uuid}/display', [ApiController::class, 'display'])->name('api.screen.display');
Route::get('/screen/{screen_uuid}/data', [ApiController::class, 'data'])->name('api.screen.data');

Route::get('/updates/static', [ApiController::class, 'GetLatestStaticUpdateTimestamp'])->name('api.updates.static');
Route::get('/updates/service', [ApiController::class, 'GetLatestServiceAlertUpdateTimestamp'])->name('api.updates.service');
Route::get('/updates/trip', [ApiController::class, 'GetLatestTripUpdateTimestamp'])->name('api.updates.trip');

Route::get('/departures/{stop_id}', [ApiController::class, 'GetDepartures'])->name('api.departures');