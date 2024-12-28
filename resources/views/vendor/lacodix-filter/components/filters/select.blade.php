@php
    $multiple = $filter->mode->needsMultipleValues();
    $varName = $filter->queryName();
    $name = $varName . ($multiple ? '[]' : '');
    $classes = 'select ' . $varName;
@endphp

<x-lacodix-filter::filters.layout
    :filter="$filter"
    :class="$classes"
>
    <select
        class="filter-input w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        
        name="{{$name}}"
        
        @if ($multiple)
            multiple="multiple"
        @endif
    >
        <option value="">&mdash;</option>
        @foreach ($filter->options() as $key => $option)
            @if (!is_null(request()->get($varName)) && in_array($option, request()->get($varName)))
                <option value="{{ $option }}" selected>
                    {{ is_numeric($key) ? $option : $key }}
                </option>
            @else
            <option value="{{ $option }}">
                {{ is_numeric($key) ? $option : $key }}
            </option>
            @endif
            
        @endforeach
    </select>
</x-lacodix-filter::filters.layout>
