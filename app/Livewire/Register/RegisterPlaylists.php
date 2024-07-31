<?php

namespace App\Livewire\Register;

use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class RegisterPlaylists extends Component
{
    public Collection $playlists;

    public function mount()
    {
        $this->playlists = collect([]);
    }

    #[On('playlist-added')]
    public function refreshPlaylists($newPlaylist)
    {
        $this->playlists->push($newPlaylist);
    }

    public function submit()
    {
        if (count($this->playlists)) {
            session()->flash('flash.banner', 'We are reviewing your playlist. It may take up to 48hours.');
            session()->flash('flash.bannerStyle', 'warning');
        }

        return $this->redirectRoute('profile.show');
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.register.register-playlists');
    }
}
