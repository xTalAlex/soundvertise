<x-app-layout>
    <x-slot name="header">
        {{ auth()->user()->name }}
    </x-slot>

    <div class="sm:pb-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-12 place-items-center mt-12 mb-20">
                <div class="order-2 md:order-1">
                    <a href="{{ route('pairings.index') }}">
                        <div
                            class="rounded-full border-2 border-white shadow-2xl w-32 sm:w-44 text-center py-3 bg-gradient-to-r from-primary-500 to-primary-600">
                            REQUEST
                        </div>
                    </a>
                </div>
                <div class="order-1 md:order-2">
                    <!-- Current Profile Photo -->
                    <div class="" x-show="! photoPreview">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}"
                            class="rounded-full size-52 object-cover">
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
        </div>

        <div class="flex justify-center mt-10 sm:mt-0">
            @livewire('playlist-index')
        </div>
    </div>
</x-app-layout>
