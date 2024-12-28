<?php

namespace App\Models;

use App\Models\Route;
use App\Models\Shape;
use App\Models\Calendar;
use App\Models\StopTime;
use Illuminate\Database\Eloquent\Model;
use Lacodix\LaravelModelFilter\Traits\HasFilters;
use Lacodix\LaravelModelFilter\Traits\IsSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trip extends Model
{
    /** @use HasFactory<\Database\Factories\TripFactory> */
    use HasFactory;

    protected $primaryKey = 'trip_id';


    function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }

    function stopTimes()
    {
        return $this->hasMany(StopTime::class, 'trip_id', 'trip_id');
    }

    function calendar()
    {
        return $this->belongsTo(Calendar::class, 'service_id', 'service_id');
    }

    function shape()
    {
        return $this->hasMany(Shape::class, 'shape_id', 'shape_id');
    }
}
