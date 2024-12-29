<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StopsController;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/data', function () {
        //return view('data.index');
        abort(404);
    })->name('data.index');

    Route::get('/stops', [StopsController::class, 'index'])->name('data.stops.index');
    Route::get('/stops/{stop_id}', [StopsController::class, 'show'])->name('data.stops.show');

    Route::get('/routes', [RoutesController::class, 'index'])->name('data.routes.index');
    Route::get('/routes/{route_id}', [RoutesController::class, 'show'])->name('data.routes.show');

    Route::get('/trips/{trip_id}', function () {
        abort(404);
    })->name('data.trips.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
