<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/galaxy', function () {
    $genres = App\Models\Genre::query()
        ->orderBy('order', 'asc')
        ->orderBy('id', 'asc')
        ->get();

    return view('galaxy', compact('genres'));
})->name('galaxy');

Route::get('/planet/{genre:slug}', function (\App\Models\Genre $genre) {
    return view('planet', compact('genre'));
})->name('planet');

Route::prefix('spotify')->group(function () {
    Route::get('auth', [\App\Http\Controllers\SpotifyController::class, 'redirect'])->name('spotify.redirect');
    Route::get('callback', [\App\Http\Controllers\SpotifyController::class, 'callback']);
    Route::get('playlists', [\App\Http\Controllers\SpotifyController::class, 'playlists']);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('playlists', \App\Livewire\PlaylistIndex::class)->name('playlists.index');
    Route::get('songs', \App\Livewire\SongIndex::class)->name('songs.index');
    Route::get('pairings', \App\Livewire\PairingIndex::class)->name('pairings.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $submissions = auth()->user()->submissions()
            ->with('song', 'playlist')
            ->orderBy('created_at', 'desc')->get();

        return view('dashboard', compact('submissions'));
    })->name('dashboard');
});
