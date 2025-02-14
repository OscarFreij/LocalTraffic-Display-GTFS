<x-display-layout>
    <x-slot name="head">
        
    </x-slot>
    
    <x-slot name="dataScripts">
        <script>
            var screen = @json($screen);
        </script>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
            {{ $screen->long_name }}
        </h2>
    </x-slot>
    <div class="pb-3 pt-3 w-full">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-2 sm:p-4 pl-4  bg-white dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-auto text-center font-semibold text-xl text-start text-gray-800 dark:text-gray-200 leading-tight">
                    <p class="text-center" name="stop_name">#STOP_NAME#</p>
                </div>
            </div>
        </div>
    </div>
    
    <div id="stops-container" class="grid grid-flow-row auto-rows-max w-full h-full">

    </div>

    <div class="hidden" name="template_row_onTime">
        <div class="pb-3 pt-3 w-full">
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="pl-4 sm:pl-8 bg-green-800 shadow sm:rounded-lg">
                    <div class="py-4 sm:py-8 pl-4 sm:pl-8 pr-8 sm:pr-16 bg-white dark:bg-gray-800 sm:rounded-lg sm:rounded-s-none">
                        <div class="max-w-auto grid grid-cols-3 font-semibold text-xl text-start text-gray-800 dark:text-gray-200 leading-tight">
                            <p class="text-start">#ROUTE_NUMBER# : #TRIP_DESTINATION#</p>
                            <p class="text-center">#STOP_TIME#</p>
                            <p class="text-end">#STOP_TIME_MINUTES_LEFT#</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden" name="template_row_late">
        <div class="pb-3 pt-3 w-full">
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="pl-4 sm:pl-8 bg-green-800 shadow sm:rounded-lg">
                    <div class="py-4 sm:py-8 pl-4 sm:pl-8 pr-8 sm:pr-16 bg-white dark:bg-gray-800 sm:rounded-lg sm:rounded-s-none">
                        <div class="max-w-auto grid grid-cols-3 font-semibold text-xl text-start text-gray-800 dark:text-gray-200 leading-tight">
                            <p class="text-start">#ROUTE_NUMBER# : #TRIP_DESTINATION#</p>
                            <p class="text-center"><span class="text-red-500 line-through">#STOP_TIME#</span> > <span>#RT_STOP_TIME#</span></p>
                            <p class="text-end">#STOP_TIME_MINUTES_LEFT#</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden" name="template_row_cancelled">
        <div class="pb-3 pt-3 w-full">
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="pl-4 sm:pl-8 bg-green-800 shadow sm:rounded-lg">
                    <div class="py-4 sm:py-8 pl-4 sm:pl-8 pr-8 sm:pr-16 bg-white dark:bg-gray-800 sm:rounded-lg sm:rounded-s-none">
                        <div class="max-w-auto grid grid-cols-3 font-semibold text-xl text-start text-gray-800 dark:text-gray-200 leading-tight">
                            <p class="text-start">#ROUTE_NUMBER# : #TRIP_DESTINATION#</p>
                            <p class="text-center">#STOP_TIME#</p>
                            <p class="text-end">CANCELED</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden" name="template_row_early">
        <div class="pb-3 pt-3 w-full">
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="pl-4 sm:pl-8 bg-cyan-800 shadow sm:rounded-lg">
                    <div class="py-4 sm:py-8 pl-4 sm:pl-8 pr-8 sm:pr-16 bg-white dark:bg-gray-800 sm:rounded-lg h-50">
                        <div class="max-w-auto grid grid-cols-3 font-semibold text-xl text-start text-gray-800 dark:text-gray-200 leading-tight">
                            <p class="text-start">#ROUTE_NUMBER# : #TRIP_DESTINATION#</p>
                            <p class="text-center"><span class="text-cyan-500 line-through">#STOP_TIME#</span> > <span>#RT_STOP_TIME#</span></p>
                            <p class="text-end">#STOP_TIME_MINUTES_LEFT#</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden" name="template_row_noDepartures">
        <div class="pb-3 pt-3 w-full">
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-2 sm:p-4 pl-4  bg-white dark:bg-gray-800 sm:rounded-lg">
                    <div class="max-w-auto text-center font-semibold text-xl text-start text-gray-800 dark:text-gray-200 leading-tight flex flex-col justify-center">
                        <p class="text-center mb-4">No departures for this station was found!</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="min-w-16 h-16 stroke-red-600 self-center">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-display-layout>