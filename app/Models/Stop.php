<?php

namespace App\Models;

use App\Models\StopTime;
use App\Models\Transfer;
use App\Models\Filters\StopNameFilter;
use Illuminate\Database\Eloquent\Model;
use Lacodix\LaravelModelFilter\Traits\HasFilters;
use App\Models\Filters\StopHasParentStationFilter;
use Lacodix\LaravelModelFilter\Traits\IsSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stop extends Model
{
    /** @use HasFactory<\Database\Factories\StopFactory> */
    use HasFactory;
    use IsSearchable;
    use HasFilters;

    protected array $searchable = [
        'stop_name',
    ];

    protected array $filters = [
        StopNameFilter::class,
        StopHasParentStationFilter::class,
    ];
    

    protected $primaryKey = 'stop_id';

    function stopTimes()
    {
        return $this->hasMany(StopTime::class, 'stop_id', 'stop_id');
    }

    function transfers()
    {
        return $this->hasMany(Transfer::class, 'from_stop_id', 'stop_id');
    }
}
