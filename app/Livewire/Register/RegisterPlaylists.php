<?php

namespace App\Livewire\Register;

use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class RegisterPlaylists extends Component
{
    public Collection $playlists;

    public bool $confirmingPlaylistDeletion = false;

    public ?string $playlistSpotifyId;

    public function mount()
    {
        $this->playlists = collect([]);

        if (auth()->user()->playlists()->exists()) {
            return $this->redirectRoute('profile.show');
        }
    }

    #[On('playlist-added')]
    public function refreshPlaylists($newPlaylist)
    {
        $this->playlists->push($newPlaylist);
    }

    public function confirmPlaylistDeletion($playlistSpotifyId)
    {
        $this->playlistSpotifyId = $playlistSpotifyId;
        $this->confirmingPlaylistDeletion = true;
    }

    public function deletePlaylist()
    {
        $deleted = auth()->user()->playlists()->where('spotify_id', $this->playlistSpotifyId)->delete();
        $this->playlists = $this->playlists->filter(fn ($playlist) => $playlist['spotify_id'] != $this->playlistSpotifyId);
        $this->playlistSpotifyId;
        $this->confirmingPlaylistDeletion = false;
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
