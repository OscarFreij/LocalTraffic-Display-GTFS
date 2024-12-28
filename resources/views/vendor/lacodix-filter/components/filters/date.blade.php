@php
    $multiple = $filter->mode->needsMultipleValues();
    $varName = $filter->queryName();
    $name = $varName . ($multiple ? '[]' : '');
    $classes = 'date ' . $varName;
@endphp
<x-lacodix-filter::filters.layout
    :filter="$filter"
    :class="$classes"
>
    @if ($multiple)
        <input
            class="filter-input w-full sm:w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            name="{{ $name }}"
            type="date"
            id="{{ $name }}_from"
            
            value="{{ request()->get($varName, [])[0] ?? '' }}"
        >
        <input
            class="filter-input w-full sm:w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            name="{{ $name }}"
            type="date"
            id="{{ $name }}_to"
            
            value="{{ request()->get($varName, [])[1] ?? '' }}"
        >
    @else
        <input
            class="filter-input w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            name="{{ $name }}"
            type="date"
            
            value="{{ request()->get($varName, '') }}"
        >
    @endif
</x-lacodix-filter::filters.layout>