<?php

namespace App\Models\Filters;

use Lacodix\LaravelModelFilter\Enums\FilterMode;
use Lacodix\LaravelModelFilter\Filters\StringFilter;

class ScreenNameFilter extends StringFilter
{
    protected string $field = 'long_name';
    protected string $title = "Name";
    public FilterMode $mode = FilterMode::CONTAINS;
}
