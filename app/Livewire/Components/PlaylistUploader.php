<?php

namespace App\Livewire\Components;

use App\Models\Genre;
use App\Services\SpotifyService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class PlaylistUploader extends Component
{
    use WithFileUploads;

    public $confirmingPlaylistCreation = false;

    public $fetchedPlaylists = [];

    public $newPlaylistUrl = null;

    #[Rule([
        'validatedPlaylist' => 'required|array',
        'validatedPlaylist.spotify_user_id' => 'required|string',
        'validatedPlaylist.spotify_id' => 'required|string',
        'validatedPlaylist.url' => 'nullable|string',
        'validatedPlaylist.name' => 'required|string',
        'validatedPlaylist.description' => 'nullable|string',
        'validatedPlaylist.collaborative' => 'nullable|boolean',
        'validatedPlaylist.followers_total' => 'required|integer',
        'validatedPlaylist.tracks_total' => 'required|integer',
    ], attribute: [
    ])]
    public $validatedPlaylist;

    #[Rule('required|exists:genres,id')]
    public $genre;

    #[Rule('required|mimes:jpg,jpeg,png|max:20000')]
    public $screenshot1;

    #[Rule('required|mimes:jpg,jpeg,png|max:20000')]
    public $screenshot2;

    public function mount()
    {
        $this->fetchedPlaylists = collect();
    }

    public function confirmPlaylistCreation()
    {
        $this->confirmingPlaylistCreation = true;
    }

    public function cancelPlaylistCreation()
    {
        $this->reset();
        $this->resetErrorBag();
    }

    public function fetchPlaylists(SpotifyService $spotifyService)
    {
        $userPlaylistsIds = auth()->user()->playlists->pluck('spotify_id');
        $response = $spotifyService->getUserPlaylists(auth()->user());
        if ($response) {
            $this->fetchedPlaylists = $response->filter(fn ($playlist) => ! $userPlaylistsIds->contains($playlist['id']));
        }
    }

    public function checkPlaylist(SpotifyService $spotifyService)
    {
        $this->resetErrorBag();

        $playlistId = $spotifyService->getPlaylistIdFromUrl($this->newPlaylistUrl);

        $response = $spotifyService->getUserPlaylist(auth()->user(), $playlistId);

        if ($response) {
            if (! $response->has('errors')) {
                $playlist = $response;

                if ($playlist['tracks']['total'] >= config('soundvertise.min_playlist_followers')) {
                    $this->validatedPlaylist = [
                        'spotify_id' => $playlist['id'],
                        'spotify_user_id' => $playlist['owner']['id'], // = auth()->user()->spotify_id,
                        'url' => $playlist['external_urls']['spotify'],
                        'name' => $playlist['name'],
                        'description' => $playlist['description'],
                        'collaborative' => $playlist['collaborative'],
                        'tracks_total' => $playlist['tracks']['total'],
                        'followers_total' => $playlist['followers']['total'],
                    ];
                } else {
                    $this->addError('newPlaylistUrl', 'This playlist does not have enough followers. At least '.config('soundvertise.min_playlist_followers').' required.');
                }
            } else {
                $this->addError('newPlaylistUrl', collect($response['errors'])->first());
            }
        } else {
            $this->addError('newPlaylistUrl', 'Cannot find playlist with giver url or id');
        }
    }

    public function storePlaylist()
    {
        $this->resetErrorBag();

        $this->validate();

        if ($this->validatedPlaylist) {
            DB::transaction(function () {
                $stored = auth()->user()->playlists()->updateOrCreate([
                    'spotify_id' => $this->validatedPlaylist['spotify_id'],
                ], [
                    'spotify_user_id' => $this->validatedPlaylist['spotify_user_id'], // = auth()->user()->spotify_id,
                    'genre_id' => $this->genre,
                    'url' => $this->validatedPlaylist['url'],
                    'name' => $this->validatedPlaylist['name'],
                    'description' => $this->validatedPlaylist['description'],
                    'collaborative' => $this->validatedPlaylist['collaborative'],
                    'tracks_total' => $this->validatedPlaylist['tracks_total'],
                    'followers_total' => $this->validatedPlaylist['followers_total'],
                ]);

                $stored->addMedia($this->screenshot1)->toMediaCollection('screenshots');
                $stored->addMedia($this->screenshot2)->toMediaCollection('screenshots');
            });

            $this->dispatch('playlist-added');
            $this->reset();
            $this->confirmingPlaylistCreation = false;
        } else {
            //
        }
    }

    public function render()
    {
        return view('livewire.components.playlist-uploader', [
            'genres' => Genre::all(),
        ]);
    }
}
