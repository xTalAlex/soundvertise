<?php

namespace App\Livewire;

use App\Models\Genre;
use App\Services\SpotifyService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RegistrationWizard extends Component
{
    public $spotifyUser;

    public $spotifyId;

    public $accessToken;

    public $avatar;

    public $name;

    public $email;

    public Collection $fetchedPlaylists;

    public $fetchedPlaylist = null;

    public ?string $newPlaylist;

    public ?string $selectedPlaylist;

    public ?int $selectedGenre;

    public function mount(SpotifyService $spotifyService)
    {
        $spotifyUser = collect(session('spotifyUser'));
        if ($spotifyUser->isEmpty()) {
            session()->flash('flash.banner', 'Session expired.');
            session()->flash('flash.bannerStyle', 'danger');

            return $this->redirectRoute('login');
        }

        $this->spotifyUser = $spotifyUser;

        $this->spotifyId = $spotifyUser['id'];
        $this->avatar = $spotifyUser['images'][1]['url'] ?? null;
        $this->name = $spotifyUser['name'];
        $this->email = $spotifyUser['email'];
        $this->accessToken = $spotifyUser['accessTokenResponseBody']['access_token'];

        $this->fetchedPlaylists = collect();
    }

    public function fetchPlaylists(SpotifyService $spotifyService)
    {
        $this->fetchedPlaylists = $spotifyService->getSpotifyUserPlaylists($this->spotifyId, $this->accessToken);
    }

    public function selectPlaylist($playlistId)
    {
        $this->selectedPlaylist = $playlistId;
    }

    public function checkPlaylist(SpotifyService $spotifyService)
    {
        $this->selectedPlaylist = $this->newPlaylist ?? $this->selectedPlaylist;
        $this->fetchPlaylist($spotifyService);
    }

    public function fetchPlaylist(SpotifyService $spotifyService)
    {
        $spotifyPlaylistId = $spotifyService->getPlaylistIdFromUrl($this->selectedPlaylist);

        $this->fetchedPlaylist = $spotifyService->getSpotifyUserPlaylist($this->spotifyId, $spotifyPlaylistId, $this->accessToken);

        if ($this->fetchedPlaylist) {
            // $this->fetchedPlaylists = $this->fetchedPlaylists->filter(
            //     fn ($spotifyPlaylist) => $spotifyPlaylist['id'] != $fetchedPlaylist['id']
            // )->prepend($fetchedPlaylist);
        } else {
            $this->addError('fetchedPlaylist', 'Spotify found no playlists with given ID');
        }
    }

    public function register(SpotifyService $spotifyService)
    {
        DB::transaction(function () use ($spotifyService) {
            // crea utente
            //$spotifyUser = collect(session('spotifyUser'));
            $spotifyUser = $this->spotifyUser;
            $user = $spotifyService->createUser($spotifyUser);

            // crea playlist
            $playlist = $user->playlists()->create([
                'spotify_id' => $this->fetchedPlaylist['id'],
                'user_id' => $user->id,
                'spotify_user_id' => $user->spotify_id,
                'genre_id' => $this->selectedGenre,
                'url' => $this->fetchedPlaylist['external_urls']['spotify'],
                'name' => $this->fetchedPlaylist['name'],
                'description' => $this->fetchedPlaylist['description'],
                'collaborative' => $this->fetchedPlaylist['collaborative'],
                'tracks_total' => $this->fetchedPlaylist['tracks']['total'],
                'followers_total' => $this->fetchedPlaylist['followers']['total'],
            ]);

            Auth::login($user);
        });

        // redirect a profilo
        session()->flash('flash.banner', 'We are reviewing your playlist. Upload some screenshots.');
        session()->flash('flash.bannerStyle', 'warning');

        return $this->redirectRoute('profile.show');
    }

    public function render()
    {
        return view('livewire.registration-wizard', [
            'genres' => Genre::all(),
        ]);
    }
}
