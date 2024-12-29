<x-app-layout>
    <x-slot name="head">
        @vite(['resources/js/paginate_set_limit.js'])
    </x-slot>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $route->route_short_name . ($route->route_long_name ? " : " . $route->route_long_name : "") }}
        </h2>
    </x-slot>

    <div class="pb-3 pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('data.routes.partials.show-route-form')
                </div>
            </div>
        </div>
    </div>
    <div class="pb-3 pt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-auto">
                    @include('data.routes.partials.show-route-trips')
                </div>
            </div>
        </div>
    </div>

    <div class="py-3 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="flex items-center gap-4 text-center">
            <x-primary-button-link class="mt-1 block w-full justify-center" href="{{ route('data.routes.index') }}">{{ __('Go Back') }}</x-primary-button-link>
        </div>
    </div>
</x-app-layout>