<div>

    @if (!$lazyloadPlaylists || ($lazyloadPlaylists && $confirmingPlaylistCreation))
        <div class="hidden" wire:init="fetchPlaylists"></div>
    @endif

    <x-secondary-button wire:click="confirmPlaylistCreation" wire:loading.attr="disable"
        wire:target="storePlaylist">{{ __('Add Playlist') }}
        <x-loading-spinner class="size-3" wire:loading wire:target="storePlaylist"></x-loading-spinner>
    </x-secondary-button>

    <x-dialog-modal wire:model.live="confirmingPlaylistCreation">
        <x-slot name="title">
            @if (!$validatedPlaylist)
                <span>{{ __('Add playlist') }}</span>
            @else
                <div class="flex items-center space-x-2">
                    <img src="{{ $validatedPlaylist['temp_image'] }}"
                        class="size-6 rounded-full aspect-square object-cover" />
                    <div>{{ $validatedPlaylist['name'] }}</div>
                </div>
            @endif
        </x-slot>

        <x-slot name="content">

            @if (!$validatedPlaylist)
                <div x-data="{
                    newPlaylistUrl: @entangle('newPlaylistUrl'),
                    setNewPlaylistUrl(url) {
                        $wire.set('newPlaylistUrl', url);
                    }
                }">
                    <div class="w-full">
                        <div class="w-full mt-1 opacity-50">
                            {{ __('Select one of your most recent playlists or provide it\'s Spotify URL.') }}
                        </div>
                        <div class="w-full mt-1 py-4">
                            <div class="w-full" wire:loading wire:target="fetchPlaylists">
                                <div class="w-fit mx-auto">
                                    <x-loading-spinner class="size-6" />
                                </div>
                            </div>
                            <div wire:loading.remove wire:target="fetchPlaylists"
                                class="space-y-1 max-h-64 overflow-y-auto">
                                @forelse ($fetchedPlaylists as $playlist)
                                    <div class="flex space-x-2 cursor-pointer hover:bg-primary-500 rounded-md transition duration-300 p-1 items-center"
                                        x-on:click="setNewPlaylistUrl('{{ $playlist['external_urls']['spotify'] ?? $playlist['id'] }}')"
                                        :class="newPlaylistUrl ==
                                            '{{ $playlist['external_urls']['spotify'] ?? $playlist['id'] }}' ?
                                            'bg-primary-500' : ''">
                                        <img class="object-cover aspect-square size-12"
                                            src="{{ $playlist['images'][0]['url'] }}" />
                                        <div>{{ $playlist['name'] }}</div>
                                    </div>
                                @empty
                                    <div class="select-none opacity-50 text-center">
                                        {{ __('No playlists found') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="w-full mt-1">
                            <x-input id="newPlaylistUrl" class="block w-full overflow-ellipsis" type="text"
                                name="newPlaylistUrl" wire:model.live="newPlaylistUrl" :value="old('newPlaylistUrl')" required
                                autofocus placeholder="{{ __('Insert your playlist URL') }}" autocomplete="playlist"
                                x-on:click="open = true" x-on:input="open = false" />
                            <x-input-error for="newPlaylistUrl" class="mt-2"></x-input-error>
                        </div>
                    </div>
                </div>
            @else
                <div class="w-full mt-1 opacity-50">
                    {{ __('Select a genre for your playlist and upload the requested screenshot.') }}
                </div>

                <div class="w-full mt-1 grid">
                    <div class="mt-4 w-full">
                        <x-label for="genre">{{ __('Playlist main genre') }}</x-label>
                        <x-input-error for="genre" class="mt-4" />
                        <x-genre-select class="mt-4" name="genre" wire:model="genre" required />
                    </div>

                    <div class="mt-8 w-full">
                        <div x-data="{}">
                            <x-label for="screenshot" class="group">
                                {{ __('Screenshot showing your playlist growth') }}
                            </x-label>
                            <x-input-error for="screenshot" class="mt-4" />
                            <input type="file" class="hidden" wire:model="screenshot" name="screenshot" required
                                x-ref="screenshotinput" />
                            <div class="mt-4">
                                <div class="h-64 w-fit mx-auto group relative cursor-pointer"
                                    x-on:click="$refs.screenshotinput.click()">
                                    <img class="h-full object-cover mx-auto"
                                        src="{{ $screenshot && $screenshot->extension()
                                            ? $screenshot->temporaryUrl()
                                            : asset('images/playlist_screenshot_example.jpg') }}" />
                                    <div
                                        class="z-10 h-full group-hover:bg-black/80 bg-black/50 absolute inset-0 transition duration-300">
                                        <div class="grid place-items-center h-full font-medium uppercase tracking-wide">
                                            <div class="select-none group-hover:scale-110 transition duration-500 group-hover:translate-y-1"
                                                wire:loading.attr="hidden" wire:target="screenshot">
                                                {{ __('Upload') }}</div>
                                            <x-loading-spinner wire:loading wire:target="screenshot" class="size-6" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="cancelPlaylistCreation" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            @if ($validatedPlaylist)
                <x-button class="ms-3" wire:click="storePlaylist" wire:loading.attr="disabled">
                    {{ __('Submit') }}
                </x-button>
            @else
                <x-button class="ms-3" wire:click="checkPlaylist" wire:loading.attr="disabled"
                    disabled="{{ empty($newPlaylistUrl) }}">
                    {{ __('Check') }}
                </x-button>
            @endif
        </x-slot>
    </x-dialog-modal>
</div>
