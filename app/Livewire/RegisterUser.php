<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use App\Models\Genre;
use App\Models\User;
use App\Services\SpotifyService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterUser extends Component
{
    use WithFileUploads;

    public int $totSteps = 2;

    public int $step = 1;

    public UserForm $userForm;

    public ?User $user = null;

    public Collection $playlists;

    public function mount()
    {
        $spotifyUser = session('spotifyUser');
        if (! $spotifyUser) {
            session()->flash('flash.banner', 'Session expired.');
            session()->flash('flash.bannerStyle', 'danger');

            $this->step = 0;
        } else {
            $this->userForm->setUser(collect($spotifyUser));
            if ($this->userForm->spotify_token_expiration <= now()) {
                session()->forget('spotifyUser');
                session()->flash('flash.banner', 'Session timed out.');
                session()->flash('flash.bannerStyle', 'danger');

                $this->step = 0;
            }
        }
        $this->playlists = collect();
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

    public function removePlaylist($spotifyId)
    {
        $this->resetErrorBag();

        $key = $this->playlists->search(fn ($playlist) => $playlist['spotify_id'] == $spotifyId);
        if ($key !== null) {
            // se reviewed_at == null
            $this->playlists->find($key)->delete();
        }
    }

    public function register(SpotifyService $spotifyService)
    {
        $this->validate();

        $user = User::create($this->userForm->all());

        $this->user = $user;

        $this->complete();
    }

    public function complete()
    {
        Auth::login($this->user);

        session()->forget('spotifyUser');
        session()->flash('flash.banner', 'We are reviewing your playlist. It may take up to 48hours.');
        session()->flash('flash.bannerStyle', 'warning');

        return $this->redirect(route('register.playlists'), navigate: true);
    }

    public function render()
    {
        return view('livewire.register-user', [
            'genres' => Genre::all(),
        ]);
    }
}
