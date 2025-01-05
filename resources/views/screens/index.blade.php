@php
Use App\Models\Screen;
Use App\Models\User;
@endphp
<x-app-layout>
    <x-slot name="head">
        @vite(['resources/js/paginate_set_limit.js'])
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span>{{ __('Index of all screens') }}</span>
        </h2>
    </x-slot>

    <div class="pt-12 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="w-full">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        <span>//:{{ __('Screen Index Filter') }}</span>
                    </h2>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        <x-lacodix-filter::model-filters :model="Screen::class" />
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 space-y-6">
        @foreach ($screens as $screen)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <a href="{{route('screens.show', ['screen_id' => $screen->id])}}" class="group">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="w-full">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex flex-col justify-start">
                                <span>{{ $screen->long_name }}</span>
                                <span class="text-sm">Connection ID: {{ $screen->short_name }}</span>
                                <span class="text-sm">Owner: {{ User::Find($screen->user_id)->name }}</span>
                            </h2>
                        </div>
                </div>
            </a>
        </div>
        @endforeach
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <a href="{{route('screens.create')}}" class="group">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="w-full">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex justify-between">
                                <span>{{ __('Create new screen')}}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="min-w-6 h-6 group-hover:stroke-lime-600 self-center">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </h2>
                        </div>
                </div>
            </a>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        {{ $screens->onEachSide(1)->links() }}
    </div>
</x-app-layout>