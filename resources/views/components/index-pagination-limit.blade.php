@props(['disabled' => false])
<select id="paginatorLimitSelector" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'paginatorLimitSelector border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
    @php
        if (is_null($attributes->get('value')))
        {
            $limit = 10;
        }
        else
        {
            $limit = $attributes->get('value');
        }
    @endphp
    <option value="5" {{$limit == 5 ? 'selected' : ''}}>5 per page</option>
    <option value="10" {{$limit == 10 ? 'selected' : ''}}>10 per page</option>
    <option value="25" {{$limit == 25 ? 'selected' : ''}}>25 per page</option>
    <option value="50" {{$limit == 50 ? 'selected' : ''}}>50 per page</option>
</select>
