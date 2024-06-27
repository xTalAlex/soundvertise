<?php

namespace App\Livewire;

use App\Models\Genre;
use App\Models\Song;
use App\Services\SpotifyService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SongIndex extends Component
{
    public Collection $songs;

    #[Validate('required')]
    public ?string $songUrl = null;

    public $curSong = null;

    public $confirmingSongDeletion = false;

    public function storeSong(SpotifyService $spotifyService)
    {
        if (! auth()->user()->isSpotifyAuth()) {
            return $this->redirectRoute('spotify.redirect');
        }

        $this->validate();

        $spotifySongId = $this->getSonglistIdFromUrl($this->songUrl);

        $songData = $spotifyService->getSong(auth()->user(), $spotifySongId);

        $audioFeatures = $spotifyService->getSongAudioFeatures(auth()->user(), $spotifySongId);

        if ($songData) {
            $song = auth()->user()->songs()->updateOrCreate([
                'spotify_id' => $songData['id'],
            ], [
                'url' => $songData['external_urls']['spotify'],
                'name' => $songData['name'],
                'artist_id' => collect($songData['artists'])->pluck('id')->implode(','),
                'artist_name' => collect($songData['artists'])->pluck('name')->implode(','),
                'artist_genres' => collect($songData['artists'])->pluck('name')->implode(','),
                'duration_ms' => $songData['duration_ms'],
                'popularity' => $songData['popularity'],
                ...$audioFeatures->only([
                    'acousticness', 'speechiness',
                    'danceability', 'instrumentalness', 'energy',
                    'valence', 'liveness', 'loudness',
                    'mode', 'key', 'tempo',
                    'time_signature',
                ]),
            ]);
        }
    }

    public function confirmSongDeletion($songId)
    {
        $this->curSong = $this->songs->find($songId);
        $this->confirmingSongDeletion = true;
    }

    public function deleteSong()
    {
        $removed = Song::where('id', $this->curSong->id)->delete();

        if ($removed) {
            //
        } else {
            //
        }
        $this->confirmingSongDeletion = false;
        $this->curSong = null;
    }

    public function render()
    {
        $this->songs = auth()->user()->songs()->with('genre')->get();

        return view('livewire.song-index', [
            'songs' => $this->songs,
            'genres' => Genre::all(),
        ]);
    }

    /*
    |-----------------------------
    | Utils
    |-----------------------------
    */

    public function getSonglistIdFromUrl($songUrl): string
    {
        return Str::between($songUrl ?? '', 'track/', '?');
    }
}
