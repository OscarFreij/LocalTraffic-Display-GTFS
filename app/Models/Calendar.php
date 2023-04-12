<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    protected $table = 'calendar';
    protected $primaryKey = 'service_id';

    public function trip()
    {
        return $this->hasMany(Trip::class, 'service_id', 'service_id');
    }

    public function calendar_date()
    {
        return $this->hasMany(Calendar_date::class, 'service_id', 'service_id');
    }
}
