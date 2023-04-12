<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $primaryKey = 'trip_id';

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }

    public function calendar()
    {
        return $this->belongsTo(Calendar::class, 'service_id', 'service_id');
    }

    public function attribution()
    {
        return $this->hasOne(Attribution::class, 'trip_id', 'trip_id');
    }

    public function stop_time()
    {
        return $this->hasMany(Stop_time::class, 'trip_id', 'trip_id');
    }

    public function tripUpdate_record()
    {
        return $this->hasOne(TripUpdate_record::class, 'trip_id', 'trip_id');
    }
}
