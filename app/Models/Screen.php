<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Filters\ScreenNameFilter;
use Lacodix\LaravelModelFilter\Traits\HasFilters;
use Lacodix\LaravelModelFilter\Traits\IsSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Screen extends Model
{
    /** @use HasFactory<\Database\Factories\ScreenFactory> */
    use HasFactory;
    use IsSearchable;
    use HasFilters;

    protected array $searchable = [
        'short_name',
        'long_name',
    ];

    protected array $filters = [
        ScreenNameFilter::class,
    ];

    protected function casts(): array
    {
        return [
            'stop_queue' => 'array',
        ];
    }
}
