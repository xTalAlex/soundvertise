<?php

namespace App\Livewire\Register;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RegisterUser extends Component
{
    public UserForm $userForm;

    public function mount()
    {
        if (auth()->check()) {
            return $this->redirectRoute('profile.show');
        }
        $spotifyUser = session('spotifyUser');
        if (! $spotifyUser) {
            session()->flash('flash.banner', 'Session expired.');
            session()->flash('flash.bannerStyle', 'danger');

            return $this->redirectRoute('register');
        } else {
            $this->userForm->setUser(collect($spotifyUser));
            if ($this->userForm->spotify_token_expiration <= now()) {
                session()->forget('spotifyUser');
                session()->flash('flash.banner', 'Session expired.');
                session()->flash('flash.bannerStyle', 'danger');

                return $this->redirectRoute('register');
            }
        }
    }

    public function register()
    {
        $this->validate();

        $user = User::create($this->userForm->all());

        session()->forget('spotifyUser');

        Auth::login($user);

        return $this->redirect(route('register.playlists'), navigate: true);
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.register.register-user');
    }
}
