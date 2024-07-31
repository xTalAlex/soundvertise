<?php

namespace App\Livewire\Components;

use App\Models\User;
use App\Services\SpotifyService;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class PlaylistUploader extends Component
{
    use InteractsWithBanner;
    use WithFileUploads;

    public User $user;

    public $confirmingPlaylistCreation = false;

    public $lazyloadPlaylists = false;

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

    #[Rule('required|mimes:jpg,jpeg,png|max:2000')]
    public $screenshot;

    public function mount()
    {
        $this->user = auth()->user();
        $this->fetchedPlaylists = collect();
    }

    public function confirmPlaylistCreation()
    {
        $this->confirmingPlaylistCreation = true;
    }

    public function cancelPlaylistCreation()
    {
        $this->resetExcept('user', 'fetchedPlaylists');
        $this->resetErrorBag();
    }

    public function fetchPlaylists(SpotifyService $spotifyService)
    {
        $userPlaylistsIds = $this->user->playlists->pluck('spotify_id');
        $response = $spotifyService->getUserPlaylists($this->user);
        if ($response) {
            $this->fetchedPlaylists = $response->filter(fn ($playlist) => ! $userPlaylistsIds->contains($playlist['id']));
        }
    }

    public function checkPlaylist(SpotifyService $spotifyService)
    {
        $this->resetErrorBag();

        $playlistId = $spotifyService->getPlaylistIdFromUrl($this->newPlaylistUrl);

        $response = $spotifyService->getUserPlaylist($this->user, $playlistId);

        if ($response) {
            if (! $response->has('errors')) {
                $playlist = $response;

                if ($playlist['followers']['total'] >= config('soundvertise.playlist_min_followers')) {
                    if ($this->user->playlists()->where('spotify_id', $playlist['id'])->doesntExist()) {
                        $this->validatedPlaylist = [
                            'spotify_id' => $playlist['id'],
                            'spotify_user_id' => $playlist['owner']['id'], // = auth()->user()->spotify_id,
                            'url' => $playlist['external_urls']['spotify'],
                            'name' => $playlist['name'],
                            'description' => $playlist['description'],
                            'collaborative' => $playlist['collaborative'],
                            'tracks_total' => $playlist['tracks']['total'],
                            'followers_total' => $playlist['followers']['total'],
                            'temp_image' => $playlist['images'][0]['url'] ?? null,
                        ];
                    } else {
                        $this->addError('newPlaylistUrl', 'You have already submitted this playlist.');
                    }
                } else {
                    $this->addError('newPlaylistUrl', 'Only playlists with more than '.config('soundvertise.playlist_min_followers').' followers are accepted.');
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
                $stored = $this->user->playlists()->updateOrCreate([
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

                $stored->addMedia($this->screenshot)->toMediaCollection('screenshots');
            });

            $this->dispatch('playlist-added', $this->validatedPlaylist);
            $this->resetExcept('user', 'fetchedPlaylists');
            $this->confirmingPlaylistCreation = false;
        } else {
            //
        }
    }

    public function render()
    {
        return view('livewire.components.playlist-uploader');
    }
}
