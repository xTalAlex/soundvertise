<x-app-layout>
    <x-slot name="header">
        {{ auth()->user()->name }}
    </x-slot>

    <div class="my-12 space-y-12" x-data="{
        showSettings: false,
        toggleEditing() {
            this.showSettings = !this.showSettings;
            $dispatch('profile-editing-toggled', { value: this.showSettings });
        }
    }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 relative">
            <div class="grid md:grid-cols-3 gap-12 place-items-center mb-12">
                <div class="order-2 md:order-1">
                    <a href="{{ route('pairings.index') }}">
                        <div
                            class="rounded-full border-2 border-white shadow-2xl w-44 text-center py-3 bg-gradient-to-r from-primary-500 to-primary-600">
                            REQUEST
                        </div>
                    </a>
                </div>
                <div class="order-1 md:order-2">
                    @livewire('avatar-uploader')

                    <div class="mx-auto w-fit mt-2">
                        <button class="opacity-50" x-on:click="toggleEditing">
                            <span>{{ __('Settings') }}</span>
                            <span x-cloak x-show="!showSettings"><x-icon-edit-r class="inline size-4 -mt-0.5" /></span>
                            <span x-cloak x-show="showSettings"><x-icon-edit-off-r
                                    class="inline size-4 -mt-0.5" /></span>
                        </button>
                    </div>
                </div>
                <div class="order-3">
                    <a href="{{ route('pairings.index') }}">
                        <div
                            class="relative border-2 border-white rounded-full shadow-2xl w-44 text-center py-3 bg-gradient-to-r from-secondary-500 to-secondary-600">
                            MATCH <div
                                class="absolute border-2 border-white text-secondary-500 -right-5 font-display  font-bold shadow-xl text-4xl -top-5 rounded-full size-10 bg-gradient-to-tr from-white to-white grid place-items-center">
                                10
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="absolute -top-8 lg:top-0 right-4 lg:right-0">
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button title="{{ __('Logout') }}" href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        <x-icon-logout-r class="text-red-500" />
                    </button>
                </form>
            </div>
        </div>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="w-full mx-auto gap-2 grid sm:grid-cols-2" x-cloak x-show="showSettings"
                x-transition:enter="transition ease-in-out duration-300"
                x-transition:enter-start="transform opacity-50 scale-50"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="transform opacity-50 scale-100 "
                x-transition:leave-end="transform opacity-0 scale-50">
                <div class="w-full mx-auto">
                    @livewire('profile.custom-update-profile-information-form', ['compact' => true])
                </div>
                <div class="w-full mx-auto">
                    @livewire('profile.custom-update-password-form', ['compact' => true])
                </div>
                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <div class="sm:col-span-2 text-center">
                        @livewire('profile.custom-delete-user-form', ['compact' => true])
                    </div>
                @endif
            </div>
        </div>

        <div class="px-4 max-w-7xl mx-auto transition duration-500">
            @livewire('playlist-index')
        </div>
    </div>
</x-app-layout>
