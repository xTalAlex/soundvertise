<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mx-auto w-full space-y-12">
                <div class="space-y-6">
                    @forelse ($playlists as $playlist)
                        <div class="space-y-4" wire:key="{{ $playlist->id }}">
                            <x-playlist-embed :id="$playlist->spotify_id" compact="false"></x-playlist-embed>
                            <div class="flex justify-between items-center">
                                <div
                                    class="uppercase text-sm py-1 px-2 border cursor-default shadow border-primary-500 text-primary-500 rounded-lg">
                                    {{ $playlist->genre?->name }}</div>
                                <div class="w-fit">
                                    <x-secondary-button wire:click="showPlaylistAttachments('{{ $playlist['id'] }}')"
                                        wire:loading.attr="disabled" wire:target="storePlaylist">
                                        <span class="">&#128206;</span>
                                    </x-secondary-button>
                                    <x-button wire:click="deletePlaylist('{{ $playlist->id }}')"
                                        wire:loading.attr="disabled" wire:target="deletePlaylist"
                                        wire:confirm="Playlist con match in corso non possono essere eliminate">
                                        <x-loading-spinner class="size-5" wire:loading
                                            wire:target="deletePlaylist"></x-loading-spinner>
                                        <span wire:loading.remove wire:target="deletePlaylist">Cancella</span>
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="place-items-center grid h-full">
                            <div class="opacity-50">You have not selected any playlist</div>
                        </div>
                    @endforelse
                </div>
                <div>
                    <div class="flex flex-col md:flex-row">
                        <div class="flex-grow">
                            <x-input class="w-full" type="text" name="playlist_id" wire:model="newPlaylistId"
                                placeholder="https://open.spotify.com/playlist/..."></x-input>
                            <x-input-error for="newPlaylistId"></x-input-error>
                        </div>
                        <x-button type="submit" wire:click="fetchSpotifyPlaylist"><x-loading-spinner wire:loading
                                wire:target="fetchSpotifyPlaylist"></x-loading-spinner>
                            <span wire:loading.remove wire:target="fetchSpotifyPlaylist">Aggiungi</span>
                        </x-button>
                    </div>
                    <div class="space-y-6 mt-12 grid place-items-center hidden">
                        @foreach ($liveFetchedPlaylists as $playlist)
                            <div class="grid grid-cols-3 gap-x-6 gap-y-4 mb-6" wire:key="{{ $playlist['id'] }}">
                                <img class="aspect-square object-cover mx-auto"
                                    src="{{ $playlist['images'][0]['url'] }}" />
                                <div class="col-span-2">
                                    <div>{{ $playlist['name'] }}</div>
                                    <div>{{ $playlist['id'] }}</div>
                                    <div class="text-ellipsis overflow-hidden w-full">
                                        {{ $playlist['external_urls']['spotify'] }}</div>
                                    @if (!$this->isSpotifyPlaylistStored($playlist['id']))
                                        <div class="mt-4">
                                            <x-button wire:click="confirmPlaylistCreation('{{ $playlist['id'] }}')"
                                                wire:loading.attr="disabled" wire:target="storePlaylist">
                                                <x-loading-spinner wire:loading
                                                    wire:target="storePlaylist"></x-loading-spinner>
                                                <span wire:loading.remove wire:target="storePlaylist">Aggiungi</span>
                                            </x-button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div wire:loading wire:target="fetchSpotifyPlaylists">
                            <div class="h-32">
                                <div class="">
                                    <x-loading-spinner></x-loading-spinner>
                                    Fetching spotify playlists...
                                </div>
                            </div>
                        </div>
                        <div class="opacity-50 mb-4 text-center">
                            {{ auth()->user()->spotify_playlists_total != null ? 'Last fetch total playlists: ' . auth()->user()->spotify_playlists_total : '' }}
                            {{ auth()->user()->spotify_filtered_playlists_total != null ? 'Importable playlist: ' . auth()->user()->spotify_filtered_playlists_total . '/50' : '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Playlist Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingPlaylistCreation">
        <x-slot name="title">
            {{ __('Adding') }} <span class="">"{{ $this->getSpotifyPlaylistNameById($newPlaylistId) }}"</span>
        </x-slot>

        <x-slot name="content">
            {{ __('Select a Genre for your playlist') }}

            <div class="mt-4" x-data="{}"
                x-on:confirming-playlist-creation.window="setTimeout(() => $refs.genre.focus(), 250)">
                <select wire:model="selectedGenreId" x-ref="genre" class="mt-1 block w-3/4">
                    <option> - </option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
                <x-input-error for="selectedGenreId" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingPlaylistCreation')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ms-3" wire:click="storePlaylist" wire:loading.attr="disabled">
                {{ __('Add Playlist') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Show Playlist Attachments Modal -->
    <x-dialog-modal wire:model.live="showingPlaylistAttachments">
        <x-slot name="title">
            <span class="">{{ $this->showedPlaylist?->name }}</span>
        </x-slot>

        <x-slot name="content">
            {{ __('Upload a screenshot with your playlist results or ongoing ads proof to help use ranking it.') }}

            <div class="my-4">
                <input type="file" wire:model="screenshots" name="screenshots" multiple />
                @error('screenshots.*')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div>
                @if ($this->showedPlaylist)
                    @foreach ($this->showedPlaylist->getMedia('screenshots') ?? [] as $screenshot)
                        <img class="w-full aspect-video" src="{{ $screenshot->getUrl() }}" />
                    @endforeach
                @endif
                @if ($this->screenshots)
                    @foreach ($this->screenshots as $screenshot)
                        <img class="w-full aspect-video" src="{{ $screenshot->temporaryUrl() }}" />
                    @endforeach
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showingPlaylistAttachments')" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-secondary-button>

            <x-button class="ms-3" wire:click="attachScreenshotsToPlaylist" wire:loading.attr="disabled"
                wire:target="screenshots" disabled="{{ empty($this->screenshots) }}">
                <x-loading-spinner class="size-5" wire:loading wire:target="screenshots"></x-loading-spinner>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
