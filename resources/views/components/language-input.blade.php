@props(['disabled' => false])
<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
    <option value="">Select Language</option>
    @php
        $lList = App\Models\Language::All();
        $selectedId = $attributes->get('value');
    @endphp

    @foreach ($lList as $l)
        <option value="{{$l->id}}" {{$selectedId  === $l->id ? 'selected' : ''}}>{{$l->name}}</option>    
    @endforeach
</select>