<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Playlists') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-4">
                <div class="mx-auto w-full grid md:grid-cols-2 gap-12">
                    <div class="space-y-6">
                        @forelse ($playlists as $playlist)
                            <div class="space-y-4" wire:key="{{ $playlist->id }}">
                                <x-playlist-embed :id="$playlist->spotify_id"></x-playlist-embed>
                                <div class="flex justify-between items-center">
                                    <div class="">{{ $playlist->genre?->name }}</div>
                                    <div class="w-fit">
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
                        <div class="space-y-6 mt-12 grid place-items-center" wire:init="fetchSpotifyPlaylists">
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
                                                    <span wire:loading.remove
                                                        wire:target="storePlaylist">Aggiungi</span>
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
                            <!-- Add Playlist Confirmation Modal -->
                            <x-dialog-modal wire:model.live="confirmingPlaylistCreation">
                                <x-slot name="title">
                                    {{ __('Adding') }} <span
                                        class="">"{{ $this->getSpotifyPlaylistNameById($newPlaylistId) }}"</span>
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
                                    <x-secondary-button wire:click="$toggle('confirmingPlaylistCreation')"
                                        wire:loading.attr="disabled">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>

                                    <x-button class="ms-3" wire:click="storePlaylist" wire:loading.attr="disabled">
                                        {{ __('Add Playlist') }}
                                    </x-button>
                                </x-slot>
                            </x-dialog-modal>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
