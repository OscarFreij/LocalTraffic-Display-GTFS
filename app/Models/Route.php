<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Route extends Model
{
    use HasFactory;
    use Searchable;
    protected $primaryKey = 'route_id';

    public function toSearchableArray()
    {
        return [
            'route_id' => $this->route_id,
            'route_short_name' => $this->route_short_name,
            'route_long_name' => $this->route_long_name,
            'route_type' => $this->route_type,
            'route_desc' => $this->route_desc
        ];
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'agency_id');
    }

    public function trip()
    {
        return $this->hasMany(Trip::class, 'route_id', 'route_id');
    }

    public function tripUpdate_record()
    {
        return $this->hasOne(TripUpdate_record::class, 'route_id', 'route_id');
    }
}
