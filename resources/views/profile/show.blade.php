<x-app-layout>
    <x-slot name="header">
        {{ auth()->user()->name }}
    </x-slot>

    <div class="my-12 space-y-12" x-data="{ showSettings: false }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 relative">
            <div class="grid md:grid-cols-3 gap-12 place-items-center mb-12">
                <div class="order-2 md:order-1">
                    <a href="{{ route('pairings.index') }}">
                        <div
                            class="rounded-full border-2 border-white shadow-2xl w-32 sm:w-44 text-center py-3 bg-gradient-to-r from-primary-500 to-primary-600">
                            REQUEST
                        </div>
                    </a>
                </div>
                <div class="order-1 md:order-2">
                    <div class="">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}"
                            class="rounded-full size-32 sm:size-52 object-cover">
                    </div>

                    <div class="mx-auto w-fit mt-2">
                        <button class="opacity-50" x-on:click="showSettings = !showSettings">SETTINGS
                            <span x-cloak x-show="!showSettings">&#9998;</span>
                            <span x-cloak x-show="showSettings">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="order-3">
                    <a href="{{ route('pairings.index') }}">
                        <div
                            class="relative border-2 border-white rounded-full shadow-2xl w-32 sm:w-44 text-center py-3 bg-gradient-to-r from-secondary-500 to-secondary-600">
                            MATCH <div
                                class="absolute border-2 border-white text-secondary-500 -right-5 font-display  font-bold shadow-xl text-4xl -top-5 rounded-full size-10 bg-gradient-to-tr from-white to-white grid place-items-center">
                                10
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="absolute -top-8 sm:top-0 right-4 sm:right-0">
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>

        <div>
            <div class="w-fit mx-auto gap-2 grid sm:grid-cols-2" x-cloak x-show="showSettings"
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

        <div class="max-w-7xl mx-auto transition duration-500"
            :class="{
                'translate-y-12': showSettings,
                'translate-y-0': !showSettings
            }">
            @livewire('playlist-index')
        </div>
    </div>
</x-app-layout>
