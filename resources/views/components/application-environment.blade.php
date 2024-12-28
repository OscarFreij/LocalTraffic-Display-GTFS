<div {{ $attributes }}>
    <div class="text-sm text-gray-500 dark:text-gray-400">
        Enviroment: {{ env('APP_ENV') }}
    </div>
    <div class="text-sm text-gray-500 dark:text-gray-400">
        @php
            $date = env('APP_BUILD_TIMESTAMP', "N/A");
            if (!is_numeric($date))
            {
                $buildTime = "Unknown";
            }
            else
            {
                $buildTime = date('d/m/Y H:i:s', $date);;
            }
        @endphp
        Build v{{ env('APP_VERSION') }} ({{ $buildTime }})
    </div>
    <div class="text-sm text-gray-500 dark:text-gray-400">
        Built on Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </div>
</div>