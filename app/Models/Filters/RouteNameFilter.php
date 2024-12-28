<?php

namespace App\Models\Filters;

use Lacodix\LaravelModelFilter\Enums\FilterMode;
use Lacodix\LaravelModelFilter\Filters\StringFilter;

class RouteNameFilter extends StringFilter
{
    protected string $field = 'route_short_name';
    protected string $title = "Name (Id number)";
    public FilterMode $mode = FilterMode::STARTS_WITH;
}
