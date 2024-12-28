<?php

namespace App\Models;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shape extends Model
{
    /** @use HasFactory<\Database\Factories\ShapeFactory> */
    use HasFactory;

    function trips()
    {
        return $this->hasMany(Trip::class, 'shape_id', 'shape_id');
    }
}
