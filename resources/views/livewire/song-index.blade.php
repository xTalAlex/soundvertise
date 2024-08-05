<div class="max-w-lg w-full p-4">
    <div class="w-full">
        <div class="w-full overflow-hidden">
            <div class="flex">
                <div class="flex-grow w-full">
                    <x-input id="songUrl" class="w-full" type="text" name="songUrl"
                        placeholder="https://open.spotify.com/track/..." wire:model="songUrl" />
                </div>
                <x-button type="submit" wire:click="storeSong">
                    <span>{{ __('Add') }}</span>
                    <x-loading-spinner class="size-3" wire:loading wire:target="storeSong"></x-loading-spinner>
                </x-button>
            </div>
            <div>
                <x-input-error for="songUrl" class="mt-2"></x-input-error>
            </div>
            <div class="mx-auto w-full grid mt-12">
                @if (count($songs))
                    <div class="w-full grid gap-4">
                        @foreach ($songs as $song)
                            <div class="w-full">
                                <x-song-embed compact :id="$song->spotify_id" />
                                <div class="mt-4 grid place-items-center">
                                    <x-danger-button type="submit"
                                        wire:click="confirmSongDeletion('{{ $song->id }}')">
                                        <span>{{ __('Delete') }}</span>
                                        <x-loading-spinner class="size-3" wire:loading
                                            wire:target="deleteSong"></x-loading-spinner>
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
