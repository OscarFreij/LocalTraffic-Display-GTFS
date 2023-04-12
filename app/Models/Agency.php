<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Agency extends Model
{
    use HasFactory;
    use Searchable;
    protected $table = 'agency';
    protected $primaryKey = 'agency_id';

    public function toSearchableArray()
    {
        return [
            'agency_name' => $this->agency_name,
            'agency_id' => $this->agency_id
        ];
    }

    public function routes()
    {
        return $this->hasMany(Route::class, 'agency_id', 'agency_id');
    }
}
