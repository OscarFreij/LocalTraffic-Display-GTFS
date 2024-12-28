<?php

namespace App\Models;

use App\Models\Stop;
use App\Models\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transfer extends Model
{
    /** @use HasFactory<\Database\Factories\TransferFactory> */
    use HasFactory;

    function fromStop()
    {
        return $this->belongsTo(Stop::class, 'from_stop_id', 'stop_id');
    }

    function toStop()
    {
        return $this->belongsTo(Stop::class, 'to_stop_id', 'stop_id');
    }

    function fromRoute()
    {
        return $this->belongsTo(Route::class, 'from_route_id', 'route_id');
    }

    function toRoute()
    {
        return $this->belongsTo(Route::class, 'to_route_id', 'route_id');
    }
}
