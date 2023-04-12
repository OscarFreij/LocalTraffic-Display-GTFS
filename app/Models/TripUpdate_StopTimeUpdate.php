<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripUpdate_StopTimeUpdate extends Model
{
    use HasFactory;
    protected $table = 'tripUpdates_StopTimeUpdates';

    public function stop()
    {
        return $this->belongsTo(Stop::class, 'stop_id', 'stop_id');
    }

    public function tripUpdate_record()
    {
        return $this->belongsTo(TripUpdate_record::class, 'id', 'tripUpdates_record_id');
    }
}
