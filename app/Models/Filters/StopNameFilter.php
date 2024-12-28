<?php

namespace App\Models\Filters;

use Lacodix\LaravelModelFilter\Enums\FilterMode;
use Lacodix\LaravelModelFilter\Filters\StringFilter;

class StopNameFilter extends StringFilter
{
    protected string $field = 'stop_name';
    protected string $title = "Name";
    public FilterMode $mode = FilterMode::CONTAINS;
}
