<x-authentication-card>
    <x-slot name="logo">
        <ol class="text-white flex items-center w-full p-3 space-x-2 text-sm font-medium text-center shadow-sm sm:text-base sm:p-4 sm:space-x-4 rtl:space-x-reverse"
            x-data="{
                step: 2,
                totSteps: 2
            }">
            <li class="flex items-center" x-bind:class="step == 1 ? 'text-primary-500' : ''">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border rounded-full shrink-0"
                    x-bind:class="step == 1 ?
                        'border-primary-500' :
                        'border-current '">
                    1
                </span>
                User <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center" x-bind:class="step == 2 ? 'text-primary-500' : ''">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border rounded-full shrink-0"
                    x-bind:class="step == 2 ?
                        'border-primary-500' :
                        'border-current '">
                    2
                </span>
                Playlists <span class="hidden sm:inline-flex sm:ms-2">Info</span>
            </li>
        </ol>
    </x-slot>

    <x-validation-errors class="mb-4" />

    <div>
        <div>
            <div>
                <div class="w-fit mx-auto">
                    @livewire('components.playlist-uploader')
                </div>
            </div>
            <div>
                @forelse ($playlists as $playlist)
                    <div class="mt-4">
                        <x-playlist-embed id="{{ $playlist->spotify_id }}" compact="true" />
                    </div>
                @empty
                    <div class="mt-4 text-center">
                        <div>{{ __('No playlists or no followers? ') }}</div>
                        <x-button class="mt-2">{{ __('Contact us') }}</x-button>
                    </div>
                @endforelse
            </div>

        </div>

        <div class="mt-8 mb-4 flex justify-center space-x-2">
            <a href="{{ route('profile.show') }}">
                <x-button>{{ __('Complete') }}</x-button>
            </a>
        </div>

    </div>
</x-authentication-card>
