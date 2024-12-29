<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Stops') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Stops along route connected to this trip.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <table class="table-auto max-w-full w-full text-center border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm mt-1">
            <thead class="font-medium text-gray-900 dark:text-gray-100">
                <tr class="border-b border-gray-300 dark:border-gray-700">
                    <th>
                        {{ __('Queue Pos') }}
                    </th>
                    <th>
                        {{ __('Name') }}
                    </th>
                    <th>
                        {{ __('Arrival Tme') }}
                    </th>
                    <th>
                        {{ __('Departure Time') }}
                    </th>
                    <th>
                        {{ __('Status') }}
                    </th>
                </tr>
            </thead>
            <tbody class="text-gray-600 dark:text-gray-400">  
                @foreach ($trip->stopTimes as $stop_time)
                <tr class="border-b border-gray-300 dark:border-gray-700 hover:bg-purple-100 dark:hover:bg-purple-800">
                    <td>
                        {{ $stop_time->stop_sequence }}
                    </td>
                    <td>
                        {{ $stop_time->stop->stop_name }}
                    </td>
                    <td>
                        
                        @if (!is_null($stop_time->rt_arrival_time))
                        <span>{{ $stop_time->arrivalTimeFormated() }}</span>
                        <br>
                        <span>{{ $stop_time->arrivalTimeRTFormated() }}</span>
                        @else
                        <span>{{ $stop_time->arrivalTimeFormated() }}</span>
                        @endif
                    </td>
                    <td>
                        @if (!is_null($stop_time->rt_departure_time))
                        <span>{{ $stop_time->departureTimeFormated() }}</span>
                        <br>
                        <span>{{ $stop_time->departureTimeRTFormated() }}</span>
                        @else
                        <span>{{ $stop_time->departureTimeFormated() }}</span>
                        @endif
                    </td>
                    <td>
                        @switch($stop_time->status())
                            @case(0)
                            <span class="text-red-500 dark:text-green-400">{{ __('On Time') }}</span>    
                                @break
                            @case(1)
                            <span class="text-green dark:text-blue-400">{{ __('Early') }}</span>
                                @break
                            @case(2)
                            <span class="text-yellow-500 dark:text-yellow-400">{{ __('In Progress') }}</span>
                                @break
                            @case(3)
                            <span class="text-red-500 dark:text-red-400">{{ __('Cancelled') }}</span>
                                @break
                            @default
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Unknown') }}</span>
                        @endswitch
                    </td>
                </tr>
                @endforeach     
            </tbody>
        </table>
    </div>
</section>