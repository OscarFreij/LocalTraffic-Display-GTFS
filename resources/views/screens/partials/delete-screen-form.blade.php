<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Screen') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once a screen is deleted, all of its configuration data will be permanently deleted. Before deleting the screen, please download any data that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-screen-deletion')"
    >{{ __('Delete screen') }}</x-danger-button>

    <x-modal name="confirm-screen-deletion" :show="$errors->screenDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('screens.destroy', ['screen_id' => $screen->id]) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete '.$screen->long_name.'?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once an screen is deleted, all of its configuration data will be permanently deleted. Please enter the screen name to confirm you would like to permanently delete it.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="screenName" value="{{ __('Enter Name') }}" class="sr-only" />

                <x-text-input
                    id="screenName"
                    name="screenName"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Enter Name') }}"
                    :value="old('screenName')"
                />

                <x-input-error :messages="$errors->screenDeletion->get('screenName')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete Screen') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>