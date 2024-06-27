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
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
