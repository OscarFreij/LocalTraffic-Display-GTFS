@php
Use App\Models\Route;
@endphp
<x-app-layout>
    <x-slot name="head">
        @vite(['resources/js/paginate_set_limit.js'])
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span>{{ __('Index of all routes in DB') }}</span>
        </h2>
    </x-slot>

    <div class="pt-12 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="w-full">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        <span>//:{{ __('Route Index Filter') }}</span>
                    </h2>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        <x-lacodix-filter::model-filters :model="Route::class" />
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 space-y-6">
        @foreach ($routes as $route)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <a href="{{route('data.routes.show', ['route_id' => $route->route_id])}}" class="group">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="w-full">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex flex-col justify-start">
                                <span>{{ __('ID/CN') }}: {{ $route->route_short_name . ($route->route_long_name ? " : " . $route->route_long_name : "") }}</span>
                                <span>{{ __('Type:') }}: {{ $route->route_desc_string() }}</span>
                                @if (strlen(($route->route_type) > 0))
                                    <span>{{ __('Type Name:') }}: {{ $route->route_type }}</span>
                                @else
                                    <span></span>
                                @endif
                                <span>{{ $route->agency->agency_name }}</span>
                            </h2>
                        </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        {{ $routes->onEachSide(1)->links() }}
    </div>
    <div class="py-3 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="flex items-center gap-4 text-center">
            <x-primary-button-link class="mt-1 block w-full justify-center" href="{{ Route('data.index') }}">{{ __('Go Back') }}</x-primary-button-link>
        </div>
    </div>

</x-app-layout>