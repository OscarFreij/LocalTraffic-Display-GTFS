@php
    $name = $filter->queryName();
    $classes = 'boolean ' . $name;
@endphp

<x-lacodix-filter::filters.layout
    :filter="$filter"
    :class="$classes"
>
    <div class="flex flex-col space-y-2">
        @foreach ($filter->options() as $key => $option)
        <x-input-checkbox
            :name="$name.'['.(is_numeric($key) ? $option : $key) . ']'"
            :value="$key"
            :checked="(request()->get($name)[$key] ?? false)"
            :title="$option"
        />
        @endforeach
    </div>
</x-lacodix-filter::filters.layout>