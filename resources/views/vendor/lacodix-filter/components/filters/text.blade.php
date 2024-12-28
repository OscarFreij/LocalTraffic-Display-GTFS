@php
    $name = $filter->queryName();
    $classes = 'text ' . $name;
@endphp

<x-lacodix-filter::filters.layout
    :filter="$filter"
    :class="$classes"
>
    <input
        class="filter-input w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        name="{{ $name }}"
        type="text"
        value="{{ request()->get($name, '') }}"
    >
</x-lacodix-filter::filters.layout>