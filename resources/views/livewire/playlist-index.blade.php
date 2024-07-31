<div>
    @if (count($playlists))
        <div class="mx-auto flex flex-wrap justify-center gap-4">
            @foreach ($playlists as $playlist)
                <div class="" wire:key="{{ $playlist->id }}">
                    <div class="flex flex-col sm:flex-row bg-black-800 shadow-lg rounded-md py-6 px-4">
                        <div class="font-display -mt-6 w-20 text-center">
                            @if ($playlist->genre)
                                <img class="size-20 inline-block mt-2" src="{{ $playlist->genre?->icon }}" />
                            @endif
                        </div>
                        <div class="w-full sm:w-96 shrink-0 mx-2">
                            <x-playlist-embed :id="$playlist->spotify_id" compact="false"></x-playlist-embed>
                            <div class="w-fit mx-auto mt-2">
                                <x-danger-button wire:click="deletePlaylist('{{ $playlist->id }}')"
                                    wire:loading.attr="disabled" wire:target="deletePlaylist"
                                    wire:confirm="Playlist con match in corso non possono essere eliminate">
                                    <x-loading-spinner class="size-3" wire:loading
                                        wire:target="deletePlaylist"></x-loading-spinner>
                                    <span wire:loading.remove wire:target="deletePlaylist">{{ __('Delete') }}</span>
                                </x-danger-button>
                            </div>
                        </div>
                        <div class="w-20 text-center">
                            @if (!$playlist->reviewed_at)
                                <div class="text-sm opacity-50">{{ __('Under Review') }}</div>
                            @else
                                {{ $playlist->approved ? __('Approved') : _('Refused') }}
                            @endif
                            @if ($playlist->monthly_listeners)
                                <div>
                                    Level: {{ $playlist->monthly_listeners ?? 'Unknown' }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="w-fit mx-auto">
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

    <div class="opacity-50 mt-32 text-center text-sm">
        {{ auth()->user()->spotify_playlists_total != null ? __('Last fetch total playlists: ') . auth()->user()->spotify_playlists_total : '' }}
        |
        {{ auth()->user()->spotify_filtered_playlists_total != null ? __('Importable playlist: ') . auth()->user()->spotify_filtered_playlists_total . '/50' : '' }}
    </div>
</div>
