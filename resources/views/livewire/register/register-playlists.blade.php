<x-authentication-card>
    <x-slot name="logo">
        <ol class="text-white flex items-center w-full p-3 space-x-2 text-sm font-medium text-center shadow-sm sm:text-base sm:p-4 sm:space-x-4 rtl:space-x-reverse"
            x-data="{ step: 2 }">
            <li class="flex items-center" x-bind:class="step == 1 ? 'text-primary-500' : ''">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border-2 rounded-full shrink-0"
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
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border-2 rounded-full shrink-0"
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
        <div class="py-6 space-y-6">
            <div class="text-center mx-auto">
                {{ __('Add your most active Spotify Playlists (with more than :min_followers followers). For each one, you will have to select a genre and also attach a screenshot of it\'s stats.', ['min_followers' => config('soundvertise.playlist_min_followers')]) }}
            </div>
            <div class="w-fit mx-auto">
                @livewire('components.playlist-uploader')
            </div>
            <div class="space-y-2">
                @forelse ($playlists as $playlist)
                    <div class="flex justify-center items-center space-x-2">
                        <img class="object-cover aspect-square size-10 rounded-full border-2 border-secondary-500"
                            src="{{ $playlist['temp_image'] }}" />
                        <div class="">{{ $playlist['name'] }}</div>
                        <button class="text-red-500"
                            wire:click="confirmPlaylistDeletion('{{ $playlist['spotify_id'] }}')"><x-icon-close-r
                                class="size-4" /></button>
                    </div>
                @empty
                    <div class="grid place-items-center">
                        <div class="mt-8 flex justify-center space-x-2">
                            <div class="text-center text-sm opacity-50">
                                <div class="max-w-72">
                                    {{ __('You do not have a playlist at all, or anyone with at least :min_followers followers?', ['min_followers' => config('soundvertise.playlist_min_followers')]) }}
                                </div>
                                <div>{{ __('No worries, we can help you grow!') }}</div>
                            </div>
                        </div>

                        <div class="w-fit mx-auto mt-2">
                            <div wire:click="submit"
                                class="cursor-pointer border-b-2 border-transparent text-secondary-500 hover:border-b-secondary-500 transition duration-500">
                                {{ __('Contact us') }}</div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <div class="mt-8 mb-4 flex justify-end w-full">
        <div class="">
            <x-button wire:click="submit" disabled="{{ !count($playlists) }}">{{ __('Submit') }}</x-button>
        </div>
    </div>

    <!-- Delete Playlist Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingPlaylistDeletion">
        <x-slot name="title">
            {{ __('Delete playlist') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this playlist?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingPlaylistDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="deletePlaylist" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</x-authentication-card>
