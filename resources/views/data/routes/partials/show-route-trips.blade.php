<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Trips') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Trips connected to this route via Route Id.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <table class="table-auto max-w-full w-full text-center border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm mt-1">
            <thead class="font-medium text-gray-900 dark:text-gray-100">
                <tr class="border-b border-gray-300 dark:border-gray-700">
                    <th>
                        {{ __('Trip Id') }}
                    </th>
                    <th>
                        {{ __('Service Id') }}
                    </th>
                    <th>
                        {{ __('Headsign') }}
                    </th>
                    <th>
                        {{ __('Start Time') }}
                    </th>
                    <th>
                        {{ __('End Time') }}
                    </th>
                    <th>
                        {{ __('Status') }}
                    </th>
                    <th>
                        {{ __('Direction') }}
                    </th>
                </tr>
            </thead>
            <tbody class="text-gray-600 dark:text-gray-400">
                @php
                $trips = $route->trips_paginated();
                @endphp
                @for ($i = 0; $i < $trips->count(); $i++)
                @php
                $trip = $trips[$i];
                @endphp
                
                    <tr class="border-b border-gray-300 dark:border-gray-700 hover:bg-purple-100 dark:hover:bg-purple-800">
                        <td>
                            <a href="{{route('data.trips.show', ['trip_id' => $trip->trip_id])}}">{{ $trip->trip_id }}</a>
                        </td>
                        <td>
                            {{ $trip->service_id }}
                        </td>
                        <td>
                            {{ $trip->trip_headsign }}
                        </td>
                        <td>
                            {{ $trip->trip_first_stop }}
                        </td>
                        <td>
                            {{ $trip->trip_last_stop }}
                        </td>
                        <td>
                            @if ($trip->trip_status == 0)
                                <span class="text-green dark:text-blue-400">{{ __('Upcoming') }}</span>
                            @elseif ($trip->trip_status == 2)
                                <span class="text-red-500 dark:text-green-400">{{ __('Completed') }}</span>
                            @elseif ($trip->trip_status == 1)
                                <span class="text-yellow-500 dark:text-yellow-400">{{ __('In Progress') }}</span>
                            @elseif ($trip->trip_status == 3)
                                <span class="text-red-500 dark:text-red-400">{{ __('Cancelled') }}</span>
                            @else
                                <span class="text-gray-500 dark:text-gray-400">{{ __('Unknown') }}</span>
                            @endif
                        </td>
                        <td>
                            @if ($trip->direction_id == 0)
                                <span class="text-green dark:text-green-400">{{ __('Outbound') }}</span>
                            @else
                                <span class="text-blue-500 dark:text-blue-400">{{ __('Inbound') }}</span>
                            @endif
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>

        {{ $trips->onEachSide(1) }}
    </div>
</section>