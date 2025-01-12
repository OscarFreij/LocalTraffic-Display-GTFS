<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Screen Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Trip name and more information.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div>
            <x-input-label for="long_name" :value="__('Name')" />
            <x-text-input id="long_name" name="long_name" type="text" class="mt-1 block w-full" value="{{ $screen->long_name }}" disabled/>
        </div>
        <div>
            <x-input-label for="short_name" :value="__('Display UUID')" />
            <x-text-input id="short_name" name="short_name" type="text" class="mt-1 block w-full" value="{{ $screen->short_name }}" disabled/>
        </div>
        <div>
            <x-input-label for="short_name_2" :value="__('Display Link')" />
            <x-text-input id="short_name_2" name="short_name_2" type="text" class="mt-1 block w-full" value="{{ route('api.screen.display', ['screen_uuid' => $screen->short_name]) }}" disabled/>
        </div>
        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" name="description" rows="4" class='mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm' disabled>{{ $screen->description }}</textarea>
        </div>
        <div>
            <x-input-label for="longitude" :value="__('Longitude')" />
            <x-text-input id="longitude" name="longitude" type="number" class="mt-1 block w-full" value="{{ $screen->longitude }}" disabled/>
        </div>
        <div>
            <x-input-label for="latitude" :value="__('Latitude')" />
            <x-text-input id="latitude" name="latitude" type="number" class="mt-1 block w-full" value="{{ $screen->latitude }}" disabled/>
        </div>
        <div>
            <x-input-label for="time_per_stop" :value="__('Time per stop (Display time in seconds)')" />
            <x-text-input id="time_per_stop" name="time_per_stop" type="text" class="mt-1 block w-full" value="{{ $screen->time_per_stop }} s" disabled/>
        </div>
        <div>
            <x-input-label for="timezone" :value="__('Timezone')" />
            <x-text-input id="timezone" name="timezone" type="number" min="-12" max="12" step="1" class="mt-1 block w-full" value="{{ $screen->timezone }}" disabled/>
        </div>

        <div>
            <div class="relative p-4 sm:p-8 bg-slate-100 dark:bg-gray-700 shadow sm:rounded-lg overflow-auto ">
                <div class="shadow-sm">
                    <table class="border-collapse table-auto overflow-scroll w-full text-sm">
                        <thead>
                        <tr>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Stop ID</th>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Travle Time (Minutes)</th>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-center">Combine Children (Departures)</th>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-center">Enabled</th>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-center">Order</th>
                        </tr>
                        </thead>
                        <tbody id="icTableBody" class="bg-white dark:bg-slate-800">
                            @if (!is_null($screen->stop_queue) && (getType($screen->stop_queue) == "array"))
                                @foreach ($screen->stop_queue as $row)
                                <tr>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                                        <div>
                                            <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" value="{{ $row['stop_id'] }}" type="number" disabled>
                                        </div>
                                    </td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                                        <div>
                                            <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" value="{{ $row['travle_time'] }}" type="number" disabled>
                                        </div>
                                    </td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400 text-center">
                                        @if ($row['combine_children'])
                                        <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" value="{{ __('Yes') }}" type="text" disabled>    
                                        @else
                                        <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" value="{{ __('No') }}" type="text" disabled>    
                                        @endif
                                    </td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400 text-center">
                                        @if ($row['enabled'])
                                        <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" value="{{ __('Enabled') }}" type="text" disabled>    
                                        @else
                                        <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" value="{{ __('Disabled') }}" type="text" disabled>    
                                        @endif
                                    </td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                                        <div>
                                            <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" value="{{ $row['order'] }}" type="number" disabled>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach    
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button-link href="{{route('screens.edit', ['screen_id' => $screen->id])}}">{{ __('Edit') }}</x-primary-button-link>
        </div>
    </div>
</section>