<?php

namespace App\Models;

use App\Models\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agency extends Model
{
    /** @use HasFactory<\Database\Factories\AgencyFactory> */
    use HasFactory;

    function routes()
    {
        return $this->hasMany(Route::class, 'agency_id', 'agency_id');
    }
}
