<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar_date extends Model
{
    use HasFactory;

    public function calendar()
    {
        return $this->belongsTo(Calendar::class, 'service_id', 'service_id');
    }
}
