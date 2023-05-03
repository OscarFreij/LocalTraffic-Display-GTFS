<?php

use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StopController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\TripUpdateController;
use App\Http\Controllers\StopDisplayColumnController;

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

Route::resource('/screen', ScreenController::class, [
    'only' => ['show']
]);

Route::resource('/displayAPI', StopDisplayColumnController::class, [
    'only' => ['show']
]);