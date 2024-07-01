<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Songs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-4">
                <div class="flex">
                    <div class="flex-grow">
                        <x-input id="songUrl" class="w-full" type="text" name="songUrl"
                            placeholder="https://open.spotify.com/track/..." wire:model="songUrl" />
                        <x-input-error for="songUrl"></x-input-error>
                    </div>
                    <x-button type="submit" wire:click="storeSong">
                        <x-loading-spinner wire:loading wire:target="storeSong"></x-loading-spinner>
                        <span wire:loading.remove wire:target="storeSong">Aggiungi</span>
                    </x-button>
                </div>
                <div class="mx-auto w-full grid mt-12">
                    @if (count($songs))
                        <div class="grid grid-cols-3 gap-12">
                            @foreach ($songs as $song)
                                <div>
                                    <x-song-embed :id="$song->spotify_id" />
                                    <div class="mt-4 grid place-items-center">
                                        <x-danger-button type="submit"
                                            wire:click="confirmSongDeletion('{{ $song->id }}')">
                                            <x-loading-spinner wire:loading
                                                wire:target="deleteSong"></x-loading-spinner>
                                            <span wire:loading.remove wire:target="deleteSong">Delete</span>
                                        </x-danger-button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Song Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingSongDeletion">
        <x-slot name="title">
            {{ __('Deleting') }} <span class="">"{{ $curSong?->name }}"</span>
        </x-slot>

        <x-slot name="content">
            {{ __('Your Song will be gone forever.') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingSongDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ms-3" wire:click="deleteSong" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
