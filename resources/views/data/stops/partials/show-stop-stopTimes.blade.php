<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Stop Times') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Stop Times connected to this stop via Stop Id.") }}
        </p>
    </header>

    @if ($stop->childStations()->count() > 0)
    <p class="mt-1 text-sm font-medium text-gray-600 dark:text-gray-400">
        {{ __("This stop is a parent station to other stops. Child station data is displayed bellow.") }}
    </p>


    @foreach ($stop->childStations()->where('location_type', '=', '0')->get() as $stop)
    @if (strlen($stop->platform_code) > 0)
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Platform Code') }}: {{ $stop->platform_code }}
    </h2>
    @endif
    <div class="mt-6 space-y-6">
        <table class="table-auto max-w-full w-full text-center border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm mt-1">
            <thead class="font-medium text-gray-900 dark:text-gray-100">
                <tr class="border-b border-gray-300 dark:border-gray-700">
                    <th>
                        {{ __('Trip Id') }}
                    </th>
                    <th>
                        {{ __('Route ID') }}
                    </th>
                    <th>
                        {{ __('Headsign') }}
                    </th>
                    <th>
                        {{ __('Planed Arrival Tme') }}
                    </th>
                    <th>
                        {{ __('Real Arrival Tme') }}
                    </th>
                    <th>
                        {{ __('Planed Departure Time') }}
                    </th>
                    <th>
                        {{ __('Real Departure Time') }}
                    </th>
                    <th>
                        {{ __('Status') }}
                    </th>
                </tr>
            </thead>
            <tbody class="text-gray-600 dark:text-gray-400">
                @php
                $stopTimes = $stop->stopTimes_paginated();
                @endphp
                @for ($i = 0; $i < $stopTimes->count(); $i++)
                @php
                $stopTime = $stopTimes[$i];
                @endphp
                
                    <tr class="border-b border-gray-300 dark:border-gray-700 hover:bg-purple-100 dark:hover:bg-purple-800">
                        <td>
                            <a href="{{route('data.trips.show', ['trip_id' => $stopTime->trip_id])}}">{{ $stopTime->trip_id }}</a>
                        </td>
                        <td>
                            {{ $stopTime->trip()->get()[0]->route()->get()[0]->route_short_name }}
                        </td>
                        <td>
                            {{ $stopTime->stop_headsign }}
                        </td>
                        <td>
                            {{ $stopTime->arrival_time }}
                        </td>
                        <td>
                            {{ $stopTime->rt_arrival_time }}
                        </td>
                        <td>
                            {{ $stopTime->departure_time }}
                        </td>
                        <td>
                            {{ $stopTime->rt_departure_time }}
                        </td>
                        <td>
                            @if ($stopTime->status == 'Early')
                                <span class="text-green dark:text-blue-400">{{ __('Early') }}</span>
                            @elseif ($stopTime->status == 'On Time')
                                <span class="text-red-500 dark:text-green-400">{{ __('On Time') }}</span>
                            @elseif ($stopTime->status == 'Late')
                                <span class="text-yellow-500 dark:text-yellow-400">{{ __('In Progress') }}</span>
                            @elseif ($stopTime->status == 'Cancelled')
                                <span class="text-red-500 dark:text-red-400">{{ __('Cancelled') }}</span>
                            @else
                                <span class="text-gray-500 dark:text-gray-400">{{ __('Unknown') }}</span>
                            @endif
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>

        {{ $stopTimes->onEachSide(1) }}
    </div>

    @endforeach

    @else
    <div class="mt-6 space-y-6">
        <table class="table-auto max-w-full w-full text-center border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm mt-1">
            <thead class="font-medium text-gray-900 dark:text-gray-100">
                <tr class="border-b border-gray-300 dark:border-gray-700">
                    <th>
                        {{ __('Trip Id') }}
                    </th>
                    <th>
                        {{ __('Route ID') }}
                    </th>
                    <th>
                        {{ __('Headsign') }}
                    </th>
                    <th>
                        {{ __('Planed Arrival Tme') }}
                    </th>
                    <th>
                        {{ __('Real Arrival Tme') }}
                    </th>
                    <th>
                        {{ __('Planed Departure Time') }}
                    </th>
                    <th>
                        {{ __('Real Departure Time') }}
                    </th>
                    <th>
                        {{ __('Status') }}
                    </th>
                </tr>
            </thead>
            <tbody class="text-gray-600 dark:text-gray-400">
                @php
                $stopTimes = $stop->stopTimes_paginated();
                @endphp
                @for ($i = 0; $i < $stopTimes->count(); $i++)
                @php
                $stopTime = $stopTimes[$i];
                @endphp
                
                    <tr class="border-b border-gray-300 dark:border-gray-700 hover:bg-purple-100 dark:hover:bg-purple-800">
                        <td>
                            <a href="{{route('data.trips.show', ['trip_id' => $stopTime->trip_id])}}">{{ $stopTime->trip_id }}</a>
                        </td>
                        <td>
                            {{ $stopTime->trip()->get()[0]->route()->get()[0]->route_short_name }}
                        </td>
                        <td>
                            {{ $stopTime->stop_headsign }}
                        </td>
                        <td>
                            {{ $stopTime->arrival_time }}
                        </td>
                        <td>
                            {{ $stopTime->rt_arrival_time }}
                        </td>
                        <td>
                            {{ $stopTime->departure_time }}
                        </td>
                        <td>
                            {{ $stopTime->rt_departure_time }}
                        </td>
                        <td>
                            @if ($stopTime->status == 'Early')
                                <span class="text-green dark:text-blue-400">{{ __('Early') }}</span>
                            @elseif ($stopTime->status == 'On Time')
                                <span class="text-red-500 dark:text-green-400">{{ __('On Time') }}</span>
                            @elseif ($stopTime->status == 'Late')
                                <span class="text-yellow-500 dark:text-yellow-400">{{ __('In Progress') }}</span>
                            @elseif ($stopTime->status == 'Cancelled')
                                <span class="text-red-500 dark:text-red-400">{{ __('Cancelled') }}</span>
                            @else
                                <span class="text-gray-500 dark:text-gray-400">{{ __('Unknown') }}</span>
                            @endif
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>

        {{ $stopTimes->onEachSide(1) }}
    </div>
    @endif
</section>