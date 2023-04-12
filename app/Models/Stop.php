<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Stop extends Model
{
    use HasFactory;
    use Searchable;
    protected $primaryKey = 'stop_id';


    public function toSearchableArray()
    {
        return [
            'stop_name' => $this->stop_name,
            'stop_id' => $this->stop_id
        ];
    }

    public function stop_time()
    {
        return $this->hasMany(Stop_time::class, 'stop_id', 'stop_id');
    }

    public function trip()
    {
        return $this->hasManyThrough(Trip::class, Stop_time::class, 'stop_id', 'trip_id', 'stop_id', 'trip_id');
    }
}
