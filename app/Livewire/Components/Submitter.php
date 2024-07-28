<?php

namespace App\Livewire\Components;

use App\Events\SubmissionCreated;
use App\Jobs\MakePairings;
use App\Models\Genre;
use App\Models\Submission;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Submitter extends Component
{
    public Genre $genre;

    public $songs;

    public $playlists;

    public $submitted = false;

    #[Validate('required|exists:songs,id')]
    public $selectedSongId;

    #[Validate('required|exists:playlists,id')]
    public $selectedPlaylistId;

    public function mount()
    {
        $this->songs = auth()->user()->songs()
            ->where(fn ($query) => $query->where('genre_id', $this->genre->id)
                ->orWhere('genre_id', null)
            )->get();
        $this->playlists = auth()->user()->playlists()->where('genre_id', $this->genre->id)->get();
        $this->selectedSongId = $this->songs->first()?->id;
        $this->selectedPlaylistId = $this->playlists->first()?->id;
    }

    public function storeSubmission()
    {
        // disabilita se è già stata effettuata una submission durante il periodo
        // policy per non mandare submission doppie

        $this->validate();

        $submission = auth()->user()->submissions()->create([
            'song_id' => $this->selectedSongId,
            'playlist_id' => $this->selectedPlaylistId,
        ]);

        if ($submission) {
            SubmissionCreated::dispatch($submission);
            MakePairings::dispatch($submission);
            $this->submitted = true;
            $this->redirectRoute('profile.show');
        }
    }

    public function render()
    {
        return view('livewire.components.submitter');
    }
}
