<div>
    {{-- <div @class(['flex items-center space-x-2', 'hidden' => $submitted])>
        <div>
            <select id="selectedSongId" name="selectedSongId" wire:model="selectedSongId">
                @forelse ($songs as $song)
                    <option value="{{ $song->id }}">{{ $song->name }}</option>
                @empty
                    <option>-</option>
                @endforelse
            </select>
            <x-input-error for="selectedSongId" class="mt-2"></x-input-error>

        </div>
        <div>
            <select id="selectedPlaylistId" name="selectedPlaylistId" wire:model="selectedPlaylistId">
                @forelse ($playlists as $playlist)
                    <option value="{{ $playlist->id }}">{{ $playlist->name }}</option>
                @empty
                    <option>-</option>
                @endforelse
            </select>
            <x-input-error for="selectedPlaylistId" class="mt-2"></x-input-error>
        </div>
        <div>
            <x-button wire:click="storeSubmission">Submit</x-button>
        </div>
    </div> --}}

    <div class="w-full" x-data="{ open: false }" x-on:click.away="open = false">
        <button id="chooseSong"
            class="rounded-full border-2 border-white shadow-2xl text-center w-44 py-3 bg-gradient-to-br from-black-800 to-black-950"
            x-on:click="open = !open">
            <span class="uppercase font-bold tracking-widest animated-gradient-text">
                {{ __('Choose song') }}
            </span>
        </button>
        <div class="relative w-0 mx-auto">
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute z-50 mt-2 inset-x-0 mx-auto rounded-lg shadow-lg w-96 -ml-48 border-2 border-secondary-500/50 py-1 backdrop-blur-3xl origin-top"
                x-cloak>
                <div id="songIndex">
                    @livewire('song-index')
                </div>
            </div>
        </div>

        {{-- @push('bottom')
            <script type="module">
                window.tippy('#chooseSong', {
                    content: document.getElementById('songIndex'),
                    placement: 'bottom',
                    trigger: 'click',
                    maxWidth: 'none',
                    interactive: true,
                    appendTo: document.body,
                });
            </script>
        @endpush --}}
    </div>
</div>
