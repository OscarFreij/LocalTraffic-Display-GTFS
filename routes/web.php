<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\StopDisplayColumnController;
use App\Http\Controllers\TripUpdateController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('app');
});

Route::resource('/agency', AgencyController::class, [
    'only' => ['index', 'show']
]);

Route::resource('/stop', StopController::class, [
    'only' => ['index', 'show']
]);

Route::resource('/route', RouteController::class, [
    'only' => ['index', 'show']
]);

Route::resource('/displayAPI', StopDisplayColumnController::class, [
    'only' => ['show']
]);