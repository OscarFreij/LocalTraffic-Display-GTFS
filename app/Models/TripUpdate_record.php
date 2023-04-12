<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TripUpdate_StopTimeUpdate;

class TripUpdate_record extends Model
{
    use HasFactory;
    protected $table = 'tripUpdates_records';


    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id', 'trip_id');
    }

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }

    public function tripUpdate_StopTimeUpdate()
    {
        return $this->hasMany(TripUpdate_StopTimeUpdate::class, 'tripUpdates_record_id', 'id');
    }
}
