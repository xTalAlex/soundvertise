<?php

namespace App\Livewire;

use App\Models\Genre;
use App\Models\Playlist;
use App\Services\SpotifyService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PlaylistIndex extends Component
{
    public Collection $playlists;

    public Collection $liveFetchedPlaylists;

    //alpha_num e spotify_id unico per ogni utente
    #[Validate('required|unique:playlists,spotify_id|unique:playlists,url')]
    public string $newPlaylistId = '';

    #[Validate('required|exists:genres,id')]
    public ?int $selectedGenreId = null;

    /**
     * Indicates if team deletion is being confirmed.
     *
     * @var bool
     */
    public $confirmingPlaylistCreation = false;

    public function mount()
    {
        $this->playlists = auth()->user()->playlists;
        $this->liveFetchedPlaylists = collect();
    }

    public function fetchSpotifyPlaylists(SpotifyService $spotifyService)
    {
        if (! auth()->user()->isSpotifyAuth()) {
            return $this->redirectRoute('spotify.redirect');
        }
        $allFetchedPlaylists = $spotifyService->getUserPlaylists(auth()->user());

        if ($allFetchedPlaylists) {
            $this->liveFetchedPlaylists = $allFetchedPlaylists->filter(
                fn ($spotifyPlaylist) => ! $this->isSpotifyPlaylistStored($spotifyPlaylist['id'])
            );
        } else {
            //
        }
    }

    public function fetchSpotifyPlaylist(SpotifyService $spotifyService, $spotifyId = null)
    {
        if (! auth()->user()->isSpotifyAuth()) {
            return $this->redirectRoute('spotify.redirect');
        }

        $spotifyId = $this->getPlaylistIdFromUrl($this->newPlaylistId);

        $fetchedPlaylist = $spotifyService->getUserPlaylist(auth()->user(), $spotifyId);

        if ($fetchedPlaylist) {
            $this->liveFetchedPlaylists = $this->liveFetchedPlaylists->filter(
                fn ($spotifyPlaylist) => $spotifyPlaylist['id'] != $fetchedPlaylist['id']
            )->prepend($fetchedPlaylist);
        } else {
            $this->addError('newPlaylistId', 'Spotify found no playlists with given ID');
        }
    }

    /**
     * Confirm that the user would like to create a new playlist.
     *
     * @return void
     */
    public function confirmPlaylistCreation($newPlaylistId)
    {
        $this->selectedGenreId = null;
        $this->newPlaylistId = 'https://open.spotify.com/playlist/'.$newPlaylistId;

        $this->dispatch('confirming-playlist-creation');

        $this->confirmingPlaylistCreation = true;
    }

    public function storePlaylist(SpotifyService $spotifyService)
    {
        if (! auth()->user()->isSpotifyAuth()) {
            return $this->redirectRoute('spotify.redirect');
        }

        $this->validate();

        $spotifyId = $this->getPlaylistIdFromUrl($this->newPlaylistId);
        $spotifyPlaylist = $spotifyService->getUserPlaylist(auth()->user(), $spotifyId);

        if ($spotifyPlaylist) {

            if ($spotifyPlaylist['tracks']['total'] >= config('soundvertise.min_playlist_followers')) {

                $stored = auth()->user()->playlists()->updateOrCreate([
                    'spotify_id' => $spotifyPlaylist['id'],
                ], [
                    'user_id' => auth()->user()->id,
                    'genre_id' => $this->selectedGenreId,
                    'url' => $spotifyPlaylist['external_urls']['spotify'],
                    'name' => $spotifyPlaylist['name'],
                    'description' => $spotifyPlaylist['description'],
                    'collaborative' => $spotifyPlaylist['collaborative'],
                    'tracks_total' => $spotifyPlaylist['tracks']['total'],
                    'followers_total' => $spotifyPlaylist['followers']['total'],
                ]);

                if ($stored) {
                    $this->liveFetchedPlaylists = $this->liveFetchedPlaylists->filter(
                        fn ($playlist) => $playlist['id'] != $spotifyId
                    );
                    $this->reset('newPlaylistId');
                    $this->confirmingPlaylistCreation = false;
                    //
                } else {
                    //
                }
            } else {
                $this->addError('newPlaylistId', 'This playlist does not have enough followers. At least '.config('soundvertise.min_playlist_followers').' required.');
            }
        } else {
            //
        }

    }

    public function deletePlaylist($id)
    {
        $removed = Playlist::where('id', $id)->delete();

        if ($removed) {
            //
        } else {
            //
        }
    }

    public function render()
    {
        $this->playlists = auth()->user()->playlists()->with('genre')->get();

        return view('livewire.playlist-index', [
            'playlists' => $this->playlists,
            'genres' => Genre::all(),
        ]);
    }

    /*
    |-----------------------------
    | Utils
    |-----------------------------
    */

    public function getPlaylistIdFromUrl($playlistUrl): string
    {
        return Str::between($playlistUrl ?? '', 'playlist/', '?');
    }

    public function isSpotifyPlaylistStored($spotifyPlaylistId): bool
    {
        return $this->playlists->pluck('spotify_id')->contains($spotifyPlaylistId);
    }

    public function getSpotifyPlaylistNameById($spotifyPlaylistId): string
    {
        $spotifyPlaylistId = $this->getPlaylistIdFromUrl($spotifyPlaylistId);
        $playlist = $this->liveFetchedPlaylists->first(fn ($playlist) => $playlist['id'] == $spotifyPlaylistId);

        return $playlist['name'] ?? '';
    }
}
