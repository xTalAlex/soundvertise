<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Playlists') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @foreach ($playlists as $playlist)
                    <div>
                        <div>{{ $playlist['name'] }}</div>
                        <div>{{ $playlist['id'] }}</div>
                        <div>{{ $playlist['external_urls']['spotify'] }}</div>
                    </div>
                @endforeach
                <form method="POST" action="{{ route('playlists.store') }}">
                    @csrf
                    <x-input type="text" name="playlist_id"></x-input>
                    <x-input-error for="playlist_id"></x-input-error>
                    <x-button type="submit">Invia</x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
