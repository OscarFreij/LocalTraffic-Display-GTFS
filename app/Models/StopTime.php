<?php

namespace App\Models;

use App\Models\Stop;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StopTime extends Model
{
    /** @use HasFactory<\Database\Factories\StopTimeFactory> */
    use HasFactory;

    function stop()
    {
        return $this->belongsTo(Stop::class, 'stop_id', 'stop_id');
    }

    function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id', 'trip_id');
    }
}
