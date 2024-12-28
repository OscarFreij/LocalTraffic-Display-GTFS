@props([
    'model',
    'method' => 'get',
    'group' => '__default',
])

@php
    if (is_string($model)) {
        $model = new $model();
    }
@endphp

<form {{ $attributes->merge(['method' => $method]) }}>
    @foreach ($model->filterInstances($group) as $filter)
        <x-dynamic-component
            :component="$filter->component()"
            :filter="$filter"
        />
    @endforeach
    <div class="flex space-x-2">
        <x-primary-button type="submit" class="mt-2 w-1/2 justify-center">Filter</x-primary-button>
        <x-primary-button type="reset" class="mt-2 w-1/2 filter-reset-btn justify-center">Reset</x-primary-button>
    </div>
    {{ $footer ?? '' }}
</form>

<x-slot name="head_filter">
    @vite(['resources/js/clear_filter.js'])
</x-slot>