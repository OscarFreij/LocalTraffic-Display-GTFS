<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Stop Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Stop id, name, and more information.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div>
            <x-input-label for="stop_id" :value="__('ID')" />
            <x-text-input readonly id="stop_id" name="stop_id" type="text" class="mt-1 block w-full" :value="$stop->stop_id"/>
        </div>
        <div>
            <x-input-label for="stop_name" :value="__('Name')" />
            <x-text-input readonly id="stop_name" name="stop_name" type="text" class="mt-1 block w-full" :value="$stop->stop_name"/>
        </div>
        <div>
            <x-input-label for="stop_lat" :value="__('Latitude')" />
            <x-text-input readonly id="stop_lat" name="stop_lat" type="text" class="mt-1 block w-full" :value="$stop->stop_lat"/>
        </div>
        <div>
            <x-input-label for="stop_lon" :value="__('Longitude')" />
            <x-text-input readonly id="stop_lon" name="stop_lon" type="text" class="mt-1 block w-full" :value="$stop->stop_lon"/>
        </div>
        <div>
            <x-input-label for="location_type" :value="__('Type')" />
            <x-text-input readonly id="location_type" name="location_type" type="text" class="mt-1 block w-full" :value="$stop->locationTypeString()"/>
        </div>
        @if(strlen($stop->parent_station) > 0)
        <div>
            <x-input-label for="parent_station" :value="__('Parent Station')" />
            <x-text-input readonly id="parent_station" name="parent_station" type="text" class="mt-1 block w-full" :value="$stop->parentStation()->get()[0]->stop_name"/>
        <div>
        @endif
    </div>
</section>