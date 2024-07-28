<div>
    <x-secondary-button wire:click="confirmPlaylistCreation" wire:loading.attr="disable"
        wire:target="storePlaylist">{{ __('Add Playlist') }}
        <x-loading-spinner wire:loading wire:target="storePlaylist"></x-loading-spinner>
    </x-secondary-button>

    <x-dialog-modal wire:model.live="confirmingPlaylistCreation">
        <x-slot name="title">
            {{ __('Add Playlist') }}</span>
        </x-slot>

        <x-slot name="content">

            <x-validation-errors class="mb-4" />

            @if ($validatedPlaylist)
                {{ __('Select a Genre for your playlist and upload screenshots') }}

                <div class="mt-4 w-fit">
                    <x-genre-select name="genre" wire:model="genre" required />
                    <x-input-error for="genre" class="mt-2" />
                </div>

                <div class="mt-4">
                    <div class="grid sm:grid-cols-2 gap-2">
                        <div>
                            @if ($screenshot1 && $screenshot1->extension())
                                <img class="h-64 object-contain mx-auto" src="{{ $screenshot1->temporaryUrl() }}" />
                            @else
                                {{ __('First screenshot is like this.') }}
                                <img class="h-64 object-contain mx-auto"
                                    src="{{ asset('images/example_screenshot_1.jpg') }}" />
                            @endif
                            <label class="mt-2 cursor-pointer">
                                <input type="file" class="hidden" wire:model="screenshot1" required />
                                {{ __('Upload') }}
                            </label>
                        </div>

                        <div>
                            @if ($screenshot2 && $screenshot2->extension())
                                <img class="h-64 object-contain mx-auto" src="{{ $screenshot2->temporaryUrl() }}" />
                            @else
                                {{ __('Second screenshot this way.') }}
                                <img class="h-64 object-contain mx-auto"
                                    src="{{ asset('images/example_screenshot_2.webp') }}" />
                            @endif
                            <label class="mt-2 cursor-pointer">
                                <input type="file" class="hidden" wire:model="screenshot2" required />
                                {{ __('Upload') }}
                            </label>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex" x-data="{
                    open: false,
                    newPlaylistUrl: @entangle('newPlaylistUrl'),
                    setNewPlaylistUrl(url) {
                        $wire.set('newPlaylistUrl', url);
                        this.open = false;
                    }
                }" x-on:click.outside="open = false"
                    wire:init="fetchPlaylists">
                    <div class="w-full relative">
                        <div class="relative w-full mt-1">
                            <x-input id="newPlaylistUrl" class="block w-full overflow-ellipsis" type="text"
                                name="newPlaylistUrl" wire:model.live="newPlaylistUrl" :value="old('newPlaylistUrl')" required
                                autofocus placeholder="{{ __('Insert your playlist URL') }}" autocomplete="off"
                                x-on:click="open = true" x-on:input="open = false" />
                        </div>
                        <div class="absolute z-50 w-full bg-black shadow-lg mt-1 rounded-md py-4 px-6" x-cloak
                            x-show="open">
                            <div class="mb-6 select-none text-sm opacity-50">
                                {{ __('Your most recent playlists') }}
                            </div>
                            <div class="w-full" wire:loading wire:target="fetchPlaylists">
                                <div class="w-fit mx-auto">
                                    <x-loading-spinner />
                                </div>
                            </div>
                            <div wire:loading.remove wire:target="fetchPlaylists"
                                class="space-y-1 max-h-64 overflow-y-auto">
                                @forelse ($fetchedPlaylists as $playlist)
                                    <div class="flex space-x-2 cursor-pointer hover:bg-primary-500 rounded-md transition duration-200 p-1 items-center"
                                        x-on:click="setNewPlaylistUrl('{{ $playlist['external_urls']['spotify'] ?? $playlist['id'] }}')">
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
                    {{ __('Upload') }}
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
