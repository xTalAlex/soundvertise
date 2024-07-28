<div>
    <div @class(['flex items-center space-x-2', 'hidden' => $submitted])>
        <div>
            <select id="selectedSongId" name="selectedSongId" wire:model="selectedSongId">
                @forelse ($songs as $song)
                    <option value="{{ $song->id }}">{{ $song->name }}</option>
                @empty
                    <option>-</option>
                @endforelse
            </select>
            <x-input-error for="selectedSongId"></x-input-error>

        </div>
        <div>
            <select id="selectedPlaylistId" name="selectedPlaylistId" wire:model="selectedPlaylistId">
                @forelse ($playlists as $playlist)
                    <option value="{{ $playlist->id }}">{{ $playlist->name }}</option>
                @empty
                    <option>-</option>
                @endforelse
            </select>
            <x-input-error for="selectedPlaylistId"></x-input-error>
        </div>
        <div>
            <x-button wire:click="storeSubmission">Submit</x-button>
        </div>
    </div>
</div>
