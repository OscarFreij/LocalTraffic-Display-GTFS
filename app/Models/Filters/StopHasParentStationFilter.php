<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;
use Lacodix\LaravelModelFilter\Filters\BooleanFilter;

class StopHasParentStationFilter extends BooleanFilter
{
    protected string $field = 'parent_station';
    protected string $Title = 'Has Parent Station';

    public function options(): array
    {
        return [
            'hasParent' => __('Has parent'),
            'hasParentNot' => __('Dose not have parent'),
        ];
    }

    public function apply(Builder $query): Builder
    {
        if (($this->values['hasParent'] ?? false) && ($this->values['hasParentNot'] ?? false))
        {
            return $query;
        }

        if ($this->values['hasParent'] ?? false) {
            $query->where('parent_station', '!=', "");
        }
        if ($this->values['hasParentNot'] ?? false) {
            $query->where('parent_station', '=', "");;
        }

        return $query;
    }
}
