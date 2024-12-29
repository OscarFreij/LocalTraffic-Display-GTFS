<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Route Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Route id, name, and more information.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div>
            <x-input-label for="route_id" :value="__('ID')" />
            <x-text-input readonly id="route_id" name="route_id" type="text" class="mt-1 block w-full" :value="$route->route_id"/>
        </div>
        <div>
            <x-input-label for="agency" :value="__('Agency')" />
            <x-text-input readonly id="agency" name="agency" type="text" class="mt-1 block w-full" :value="$route->agency->agency_name"/>
        </div>
        <div>
            <x-input-label for="route_short_name" :value="__('Short Name (ID)')" />
            <x-text-input readonly id="route_short_name" name="route_short_name" type="text" class="mt-1 block w-full" :value="$route->route_short_name"/>
        </div>
        <div>
            <x-input-label for="route_long_name" :value="__('Long Name (CN)')" />
            <x-text-input readonly id="route_long_name" name="route_long_name" type="text" class="mt-1 block w-full" :value="$route->route_long_name"/>
        </div>
        <div>
            <x-input-label for="route_desc_string" :value="__('Type')" />
            <x-text-input readonly id="route_desc_string" name="route_desc_string" type="text" class="mt-1 block w-full" :value="$route->route_desc_string()"/>
        </div>
        <div>
            <x-input-label for="route_type" :value="__('Type Name')" />
            <x-text-input readonly id="route_type" name="route_type" type="text" class="mt-1 block w-full" :value="$route->route_type"/>
        </div>
    </div>
</section>