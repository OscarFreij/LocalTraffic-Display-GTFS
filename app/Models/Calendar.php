<?php

namespace App\Models;

use App\Models\Trip;
use App\Models\CalendarDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calendar extends Model
{
    /** @use HasFactory<\Database\Factories\CalendarFactory> */
    use HasFactory;

    function trips()
    {
        return $this->hasMany(Trip::class, 'service_id', 'service_id');
    }

    function calendarDates()
    {
        return $this->hasMany(CalendarDate::class, 'service_id', 'service_id');
    }
}
