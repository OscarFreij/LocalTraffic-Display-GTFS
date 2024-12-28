@props(['disabled' => false])
<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
    <option value="">Select country</option>
    @php
        $cList = App\Models\Country::All();
        $selectedId = $attributes->get('value');
    @endphp

    @foreach ($cList as $c)
        <option value="{{$c->id}}" {{$selectedId  === $c->id ? 'selected' : ''}}>{{$c->name}}</option>    
    @endforeach
</select>