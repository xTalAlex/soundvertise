<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use App\Models\Genre;
use App\Models\User;
use App\Services\SpotifyService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegistrationWizard extends Component
{
    use WithFileUploads;

    public int $totSteps = 2;

    public int $step = 1;

    public UserForm $userForm;

    public string $newPlaylistUrl = '';

    #[Validate([
        'playlists' => 'array|max:5',
        'playlists.*' => 'array',
        'playlists.*.genre_id' => 'required|exists:genres,id',
        'playlists.*.spotify_user_id' => 'required|string',
        'playlists.*.spotify_id' => 'required|string',
        'playlists.*.url' => 'nullable|string',
        'playlists.*.name' => 'required|string',
        'playlists.*.description' => 'nullable|string',
        'playlists.*.collaborative' => 'nullable|boolean',
        'playlists.*.followers_total' => 'required|integer',
        'playlists.*.tracks_total' => 'required|integer',
        'playlists.*.screenshots' => 'required|array|size:2',
        'playlists.*.screenshots.*' => 'required|mimes:jpg,jpeg,png|max:20000',
    ], attribute: [
        'playlists.*.genre_id' => 'playlist genre',
    ])]
    public Collection $playlists;

    public Collection $fetchedPlaylists;

    public function mount(SpotifyService $spotifyService)
    {
        $spotifyUser = session('spotifyUser');
        if (! $spotifyUser) {
            session()->flash('flash.banner', 'Session expired.');
            session()->flash('flash.bannerStyle', 'danger');

            return $this->redirectRoute('login');
        }
        $this->userForm->setUser(collect($spotifyUser));
        if ($this->userForm->spotify_token_expiration <= now()) {
            session()->forget('spotifyUser');
            session()->flash('flash.banner', 'Session timed out.');
            session()->flash('flash.bannerStyle', 'danger');

            return $this->redirectRoute('login');
        }
        $this->playlists = collect();
        $this->fetchedPlaylists = collect();
    }

    #[Computed]
    public function genres()
    {
        return Genre::all();
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
        $this->resetErrorBag();
    }

    public function nextStep()
    {
        if ($this->step == 1) {
            $this->userForm->validate();
            $this->step++;
        }
        $this->resetErrorBag();
    }

    public function fetchPlaylists(SpotifyService $spotifyService)
    {
        $response = $spotifyService->getSpotifyUserPlaylists($this->userForm->spotify_id, $this->userForm->spotify_access_token);
        if ($response) {
            $this->fetchedPlaylists = $response;
        }
    }

    public function fetchPlaylist(SpotifyService $spotifyService)
    {
        $this->resetErrorBag();

        if (! $this->newPlaylistUrl) {
            return;
        }

        if ($this->playlists->count() >= config('soundvertise.register.max_playlists')) {
            return;
        }

        $playliustSpotifyId = $spotifyService->getPlaylistIdFromUrl($this->newPlaylistUrl);

        if ($this->playlists->contains('spotify_id', $playliustSpotifyId)) {
            $this->addError('newPlaylistUrl', __('You have already added this playlist.'));
            $this->reset('newPlaylistUrl');

            return;
        }

        $response = $spotifyService->getSpotifyUserPlaylist($this->userForm->spotify_id, $playliustSpotifyId, $this->userForm->spotify_access_token);

        if (isset($response['errors'])) {
            foreach ($response['errors'] as $error => $message) {
                $this->addError('newPlaylistUrl', $message);
            }

            return;
        }
        $fetchedPlaylist = $response;

        if ($fetchedPlaylist) {
            $this->playlists->push([
                'spotify_user_id' => $fetchedPlaylist['owner']['id'] ?? null,
                'spotify_id' => $fetchedPlaylist['id'],
                'url' => $fetchedPlaylist['external_urls']['spotify'] ?? null,
                'name' => $fetchedPlaylist['name'],
                'description' => $fetchedPlaylist['description'] ?? null,
                'collaborative' => $fetchedPlaylist['collaborative'],
                'tracks_total' => $fetchedPlaylist['tracks']['total'] ?? 0,
                'followers_total' => $fetchedPlaylist['followers']['total'] ?? 0,
                'genre_id' => null,
                'screenshots' => null,
                'image' => $fetchedPlaylist['images'][0]['url'] ?? null, // temporary
            ]);
            $this->reset('newPlaylistUrl');
        } else {
            // playlist non di proprietà
            // playlist con pochi follower
            // id non valido
            // token scaduto
            $this->addError('fetchedPlaylist', __('You do not own any playlist with given URL or ID'));
        }
    }

    public function removePlaylist($spotifyId)
    {
        $this->resetErrorBag();

        $key = $this->playlists->search(fn ($playlist) => $playlist['spotify_id'] == $spotifyId);
        if ($key !== null) {
            $this->playlists->pull($key);
        }
    }

    public function register(SpotifyService $spotifyService)
    {
        $this->validate();

        DB::transaction(function () {
            // crea utente
            //$user = $spotifyService->createUser($this->userForm->all());
            $user = User::create($this->userForm->all());

            // crea playlist
            foreach ($this->playlists as $playlistData) {
                $playlist = $user->playlists()->create(collect($playlistData)->except('image', 'screenshots')->toArray());
                foreach ($playlistData['screenshots'] as $screenshot) {
                    $playlist->addMedia($screenshot)->toMediaCollection('screenshots');
                }
            }

            Auth::login($user);
        });

        // redirect a profilo
        session()->forget('spotifyUser');
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
