<?php

namespace App\Models;

use App\Models\Calendar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalendarDate extends Model
{
    /** @use HasFactory<\Database\Factories\CalendarDateFactory> */
    use HasFactory;

    function calendar()
    {
        return $this->belongsTo(Calendar::class, 'service_id', 'service_id');
    }
}
