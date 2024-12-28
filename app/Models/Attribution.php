<?php

namespace App\Models;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribution extends Model
{
    /** @use HasFactory<\Database\Factories\AttributionFactory> */
    use HasFactory;

    function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id', 'trip_id');
    }
}
