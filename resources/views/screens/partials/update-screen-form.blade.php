<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Screen Details') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Enter screen name and other details") }}
        </p>
    </header>

    <form id="updateInvoiceForm" method="post" action="{{ route('screens.update', ['screen_id' => $screen->id]) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <input type="hidden" name="id" value="{{$screen->id}}">

        <div>
            <x-input-label for="long_name" :value="__('Name')" />
            <x-text-input id="long_name" name="long_name" type="text" class="mt-1 block w-full" :value="old('long_name', $screen->long_name)" required autocomplete="long_name" />
            <x-input-error class="mt-2" :messages="$errors->get('long_name')" />
        </div>
        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" name="description" rows="4" class='mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'>{{old('description', $screen->description)}}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>
        <div>
            <x-input-label for="longitude" :value="__('Longitude')" />
            <x-text-input id="longitude" name="longitude" type="number" class="mt-1 block w-full" :value="old('longitude', $screen->longitude)" autocomplete="longitude" />
            <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
        </div>
        <div>
            <x-input-label for="latitude" :value="__('Latitude')" />
            <x-text-input id="latitude" name="latitude" type="number" class="mt-1 block w-full" :value="old('latitude', $screen->latitude)" autocomplete="latitude" />
            <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
        </div>
        <div>
            <x-input-label for="time_per_stop" :value="__('Time per stop (Display time in seconds)')" />
            <x-text-input id="time_per_stop" name="time_per_stop" type="number" min="1" step="1" class="mt-1 block w-full" :value="old('time_per_stop', $screen->time_per_stop)" required autocomplete="time_per_stop" />
            <x-input-error class="mt-2" :messages="$errors->get('time_per_stop')" />
        </div>
        <div>
            <x-input-label for="timezone" :value="__('Timezone')" />
            <x-text-input id="timezone" name="timezone" type="number" min="-12" max="12" step="1" class="mt-1 block w-full" :value="old('timezone', $screen->timezone)" required autocomplete="timezone" />
            <x-input-error class="mt-2" :messages="$errors->get('timezone')" />
        </div>

        <div>
            <div class="relative p-4 sm:p-8 bg-slate-100 dark:bg-gray-700 shadow sm:rounded-lg overflow-auto ">
                <div class="shadow-sm">
                    <table class="border-collapse table-auto overflow-scroll w-full text-sm">
                        <thead>
                        <tr>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Stop ID</th>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Travle Time (Minutes)</th>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-center">Enabled</th>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-center">Order</th>
                        </tr>
                        </thead>
                        <tbody id="icTableBody" class="bg-white dark:bg-slate-800">
                        @if (!is_null($screen->stop_queue) && (getType($screen->stop_queue) == "array"))
                            @php
                            $i = -1;
                            @endphp
                            @foreach ($screen->stop_queue as $row)
                                @php
                                $i++;
                                @endphp
                                <tr id="row_{{$i}}">
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                                        <div>
                                            <x-text-input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" id="stop_id_{{$i}}" name="stop_id_{{$i}}" :value="old('stop_id_{{$i}}',$row['stop_id'])" type="number"/>
                                        </div>
                                    </td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                                        <div>
                                            <x-text-input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" id="travle_time_{{$i}}" name="travle_time_{{$i}}" :value="old('travle_time_{{$i}}',$row['travle_time'])" type="number" min="0" step="1" required="required"/>
                                        </div>
                                    </td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400 text-center">
                                        <x-input-label for="">
                                            <select id="enabled_input_{{$i}}" name="enabled_input_{{$i}}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required="required">
                                                <option value="1" {{ $row['enabled'] == 1 ? "selected" : ""}}>Active</option>
                                                <option value="0" {{ $row['enabled'] == 0 ? "selected" : ""}}>Inactive</option>
                                            </select>
                                        </x-input-label>
                                    </td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                                        <div>
                                            <x-text-input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" id="order_{{$i}}" name="order_{{$i}}" :value="old('order_{{$i}}',$row['order'])" type="number" min="0" step="1" required="required"/>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach    
                        @endif
                        </tbody>
                    </table>
                    <div class="pt-3 x-auto">
                        <div class="flex items-center gap-4 text-center">
                            <x-primary-button class="mt-1 block w-full justify-center" type="button" id="addRow">{{ __('Add Row') }}</x-primary-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button id="updateInvoiceForm">{{ __('Update') }}</x-primary-button>
            <x-danger-button-link href="{{ route('screens.show', ['screen_id' => $screen->id]) }}">{{ __('Cancel') }}</x-danger-button-link>
            @if (session('status') === 'screen-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Updated.') }}</p>
            @endif
        </div>
    </form>
</section>


<div class="hidden">
    <table>
    <tbody>
        <tr id="rowTemplate">
            <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                <div>
                    <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" id="stop_id_x" name="stop_id_x" type="number">
                </div>
            </td>
            <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                <div>
                    <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" id="travle_time_x" name="travle_time_x" type="number" value="0" min="0" step="1" required="required">
                </div>
            </td>
            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400 text-center">
                <x-input-label for="enabled_input_x">
                    <select id="enabled_input_x" name="enabled_input_x" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required="required">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </x-input-label>
            </td>
            <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                <div>
                    <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" id="order_x" name="order_x" type="number" value="0" min=0 required="required">
                </div>
            </td>
        </tr>
    </tbody>
    </table>
</div>