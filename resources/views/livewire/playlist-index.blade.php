<div>
    @if (count($playlists))
        <div class="mx-auto flex flex-wrap justify-center gap-4">
            @foreach ($playlists as $playlist)
                <div class="w-full sm:w-96 shrink-0 mx-2 relative" wire:key="{{ $playlist->id }}">
                    <!-- Playlist Embed -->
                    <x-playlist-embed :id="$playlist->spotify_id" compact="false" dark="true"></x-playlist-embed>

                    <!-- Playlist Info -->
                    <div class="mt-1 flex justify-between rounded-lg bg-black-800 px-2 py-2 relative">

                        <!-- Genre -->
                        <div class="text-center">
                            {{-- <div class="text-sm">{{ $playlist->genre->name }}</div> --}}
                            @if ($playlist->genre?->icon)
                                <img class="size-12 inline-block" src="{{ $playlist->genre->icon }}" />
                            @endif
                        </div>

                        <!-- Level -->
                        <div>
                            Level: {{ $playlist->monthly_listeners ?? 'Unknown' }}
                        </div>

                        <!-- Status-->
                        <div class="flex flex-col space-y-2 jsutify-between">
                            <div class="mx-auto">
                                @if ($playlist->approved)
                                    <x-icon-verified-r data-tippy-content="{{ __('Approved') }}"
                                        class="cursor-pointer size-4 text-green-500 opacity-50" />
                                @elseif ($playlist->approved === false)
                                    <x-icon-block-r data-tippy-content="{{ __('Refused') }}"
                                        class="cursor-pointer size-4 text-red-500 opacity-50" />
                                @else
                                    <x-icon-hourglass-empty-r titdata-tippy-contente="{{ __('Under Review') }}"
                                        class="cursor-pointer size-4 text-yellow-500 opacity-50" />
                                @endif
                            </div>

                            <!-- Delete Button -->
                            @can('delete', $playlist)
                                <div class="w-fit mx-auto">
                                    <button class="text-sm text-red-500" wire:click="deletePlaylist('{{ $playlist->id }}')"
                                        wire:loading.attr="disabled" wire:target="deletePlaylist('{{ $playlist->id }}')"
                                        wire:confirm="Playlist con match in corso non possono essere eliminate">
                                        <x-loading-spinner class="size-3" wire:loading
                                            wire:target="deletePlaylist('{{ $playlist->id }}')"></x-loading-spinner>
                                        <span wire:loading.remove
                                            wire:target="deletePlaylist('{{ $playlist->id }}')">{{ __('Delete') }}</span>
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center opacity-50">{{ __('No playlists') }}</div>
    @endif

    <div class="w-fit mx-auto my-12">
        @livewire('components.playlist-uploader')
    </div>

    <div class="opacity-50 mt-32 text-center text-sm hidden">
        {{ auth()->user()->spotify_playlists_total != null ? __('Last fetch total playlists: ') . auth()->user()->spotify_playlists_total : '' }}
        |
        {{ auth()->user()->spotify_filtered_playlists_total != null ? __('Importable playlist: ') . auth()->user()->spotify_filtered_playlists_total . '/50' : '' }}
    </div>
</div>
