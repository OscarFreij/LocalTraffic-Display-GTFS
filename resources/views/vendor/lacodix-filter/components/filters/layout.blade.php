@props([
    'filter',
])

<div
    {{ $attributes->class('filter-container my-3') }}
    class=""
>
    <div class="filter-title">
        {{ $filter->title() }}
    </div>

    <div class="filter-content flex flex-col sm:flex-row">
        {{ $slot }}
    </div>
</div>