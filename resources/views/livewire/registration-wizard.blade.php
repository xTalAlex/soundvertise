<div class="text-black">
    {{-- <div>[id,name,email,avatar,nazionalità, password]</div>
    <div>select con nomi playlist + input link playlist</div>
    <div>check compatibilità per ogni playlist + upload screenshot </div> --}}

    <div>
        <x-input id="spotify_id" class="block mt-1 w-full" type="hidden" name="spotify_id" wire:model="spotifyId"
            :value="old('spotify_id')" required autofocus autocomplete="spotify_id" />
    </div>

    <div class="mt-4">
        <x-input id="avatar" class="block mt-1 w-full" type="hidden" name="avatar" wire:model="avatar"
            :value="old('avatar')" autofocus autocomplete="avatar" />
    </div>

    <div class="mt-4">
        <x-label for="name" value="{{ __('Name') }}" />
        <x-input id="name" class="block mt-1 w-full" type="text" name="name" wire:model="name"
            :value="old('name')" required autofocus autocomplete="name" />
    </div>

    <div class="mt-4">
        <x-label for="email" value="{{ __('Email') }}" />
        <x-input id="email" class="block mt-1 w-full" type="email" name="email" wire:model="email"
            :value="old('email')" required autocomplete="username" />
    </div>

    <div class="mt-4">
        <x-label for="country" value="{{ __('Country') }}" />
        <x-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')" autofocus
            autocomplete="country" />
    </div>

    <div class="mt-4" wire:init="fetchPlaylists" x-data="{
        open: true,
        selectedId: null
    }">
        <x-label for="playlist" value="{{ __('Your playlists') }}" />
        <x-input id="newPlaylist" class="block mt-1 w-full" type="text" name="newPlaylist" wire:model="newPlaylist"
            :value="old('newPlaylist')" required autofocus autocomplete="playlist" />
        <x-loading-spinner wire:loading wire:target="fetchPlaylists" />
        <ul class="border-white bg-white focus:border-secondary-500 focus:ring-secondary-500 rounded-md block mt-1 shadow-sm w-full"
            x-cloak x-show="open" x-on:click.outside="open = true">
            @foreach ($fetchedPlaylists as $playlist)
                <li value="{{ $playlist['id'] }}" class="flex space-x-2"
                    :class="selectedId == '{{ $playlist['id'] }}' ? 'bg-primary-500' : ''"
                    x-on:click="selectedId = '{{ $playlist['id'] }}'"
                    wire:click="selectPlaylist('{{ $playlist['id'] }}')">
                    <img class="object-cover aspect-square size-12"
                        src="{{ $playlist['images'][0]['url'] }}" />{{ $playlist['name'] }}
                </li>
            @endforeach
        </ul>
        @if ($selectedPlaylist)
            <div class="w-fit mx-auto">
                <x-button type="button" wire:click="checkPlaylist" class="mt-1 mx-auto">
                    {{ __('Check') }}
                </x-button>
            </div>
        @endif
    </div>

    @if ($fetchedPlaylist)
        <div class="mt-4">
            <x-input-error for="fetchedPlaylist" />
            <select wire:model.live="selectedGenre">
                <option>{{ __('Select a genre for your playlist') }}</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
            <x-playlist-embed id="{{ $selectedPlaylist }}" />
        </div>
    @endif

    @if ($fetchedPlaylist && $selectedGenre)
        <div class="w-fit mx-auto">
            <x-button type="button" wire:click="register" class="mt-1 mx-auto">
                {{ __('Register') }}
            </x-button>
        </div>
    @endif
    {{-- <div class="mt-4">
        <x-label for="password" value="{{ __('Password') }}" />
        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
            autocomplete="new-password" />
    </div>

    <div class="mt-4">
        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
            required autocomplete="new-password" />
    </div> --}}
</div>
