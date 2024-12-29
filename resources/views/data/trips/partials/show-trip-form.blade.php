<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Trip Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Trip id and more information.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div>
            <x-input-label for="trip_id" :value="__('ID')" />
            <x-text-input readonly id="trip_id" name="trip_id" type="text" class="mt-1 block w-full" :value="$trip->trip_id"/>
        </div>
        <div>
            <x-input-label for="route_short_name" :value="__('Route Short Name (ID)')" />
            <x-text-input readonly id="route_short_name" name="route_short_name" type="text" class="mt-1 block w-full" :value="$trip->route->route_short_name"/>
        </div>
        @if (strlen($trip->route->route_long_name) > 0)
        <div>
            <x-input-label for="route_long_name" :value="__('Route Long Name (CN)')" />
            <x-text-input readonly id="route_long_name" name="route_long_name" type="text" class="mt-1 block w-full" :value="$trip->route->route_long_name"/>
        </div>
        @endif
        <div>
            <x-input-label for="route_desc_string" :value="__('Type')" />
            <x-text-input readonly id="route_desc_string" name="route_desc_string" type="text" class="mt-1 block w-full" :value="$trip->route->route_desc_string()"/>
        </div>
        @if (strlen($trip->route->route_type) > 0 && $trip->route->route_type != "\r")
        <div>
            <x-input-label for="route_type" :value="__('Type Name')" />
            <x-text-input readonly id="route_type" name="route_type" type="text" class="mt-1 block w-full" :value="$trip->route->route_type"/>
        </div>
        @endif
        @php
        $tripExtended = $trip->statusAndTimes();
        @endphp
        <div>
            <x-input-label for="trip_first_stop" :value="__('Start Time')" />
            <x-text-input readonly id="trip_first_stop" name="trip_first_stop" type="text" class="mt-1 block w-full" :value="$tripExtended->trip_first_stop"/>
        </div>
        <div>
            <x-input-label for="trip_last_stop" :value="__('End Time')" />
            <x-text-input readonly id="trip_last_stop" name="trip_last_stop" type="text" class="mt-1 block w-full" :value="$tripExtended->trip_last_stop"/>
        </div>
        <div>
            <x-input-label for="trip_status" :value="__('Status')" />
            @if ($tripExtended->trip_status == 0)
                <x-text-input readonly id="trip_status" name="trip_status" type="text" class="mt-1 block w-full text-green dark:text-blue-400" value="{{ __('Upcoming') }}"/>
            @elseif ($tripExtended->trip_status == 2)
                <x-text-input readonly id="trip_status" name="trip_status" type="text" class="mt-1 block w-full text-red-500 dark:text-green-400" value="{{ __('Completed') }}"/>
            @elseif ($tripExtended->trip_status == 1)
                <x-text-input readonly id="trip_status" name="trip_status" type="text" class="mt-1 block w-full text-yellow-500 dark:text-yellow-400" value="{{ __('In Progress') }}"/>
            @elseif ($tripExtended->trip_status == 3)
                <x-text-input readonly id="trip_status" name="trip_status" type="text" class="mt-1 block w-full text-red-500 dark:text-red-400" value="{{ __('Cancelled') }}"/>
            @else
                <x-text-input readonly id="trip_status" name="trip_status" type="text" class="mt-1 block w-full text-gray-500 dark:text-gray-400" value="{{ __('Unknown') }}"/>
            @endif
        </div>
    </div>
</section>