<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class RegisterPlaylists extends Component
{
    public Collection $playlists;

    public function mount()
    {
        $this->playlists = auth()->user()->playlists;
    }

    #[On('playlist-added')]
    public function refreshPlaylists()
    {
        $this->playlists = auth()->user()->playlists;
    }

    public function complete()
    {
        session()->flash('flash.banner', 'We are reviewing your playlist. It may take up to 48hours.');
        session()->flash('flash.bannerStyle', 'warning');

        return $this->redirectRoute('profile.show');
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.register-playlists');
    }
}
