<?php

namespace App\Livewire\Components;

use App\Events\SubmissionCreated;
use App\Jobs\MakePairings;
use App\Models\Genre;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Submitter extends Component
{
    public Song $song;

    public Genre $genre;

    public Playlist $playlist;

    public $submitted = false;

    #[Validate('required|exists:songs,id')]
    public $selectedSongId;

    #[Validate('required|exists:playlists,id')]
    public $selectedPlaylistId;

    public function mount()
    {
        if (Auth::check()) {
            // selectable genres by playlist pluck genre_id
        }
    }

    public function storeSubmission()
    {
        // disabilita se è già stata effettuata una submission durante il periodo
        // policy per non mandare submission doppie

        $this->validate();

        dd('STORE SUBMISSION');

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
