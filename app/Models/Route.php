<?php

namespace App\Models;

use App\Models\Trip;
use App\Models\Agency;
use App\Models\Filters\RouteNameFilter;
use Illuminate\Database\Eloquent\Model;
use Lacodix\LaravelModelFilter\Traits\HasFilters;
use Lacodix\LaravelModelFilter\Traits\IsSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    /** @use HasFactory<\Database\Factories\RouteFactory> */
    use HasFactory;
    use IsSearchable;
    use HasFilters;

    protected array $searchable = [
        'route_short_name',
    ];

    protected array $filters = [
        RouteNameFilter::class,
    ];

    protected $primaryKey = 'route_id';

    function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'agency_id');
    }

    function trips()
    {
        return $this->hasMany(Trip::class, 'route_id', 'route_id');
    }

    function route_desc_string()
    {
        switch ($this->route_desc) {
            case '100':
                return "Railway Service";
            case '101':
                return "High Speed Rail Service";
            case '102':
                return "Long Distance Rail Service";
            case '105':
                return "Sleeper Rail Service";
            case '106':
                return "Regional Rail Service";
            case '401':
                return "Metro Service";
            case '700': 
                return "Bus Service";
            case '714':
                return "Rail Replacement Bus Service";
            case '900':
                return "Tram Service";
            case '1000':
                return "Water Transport Service";
            case '1501':
                return "Communal Taxi Service";
            default:
                return "Other";
        }
    }
}
