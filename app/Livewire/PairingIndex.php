<?php

namespace App\Livewire;

use Livewire\Component;

class PairingIndex extends Component
{
    public function mount() {}

    public function render()
    {
        return view('livewire.pairing-index', [
            'submission' => auth()->user()?->submissions()->latest()->first(),
            'pairings' => auth()->user()?->pairings()
                ->with([
                    'submission.song',
                    'submission.playlist',
                    'pairedSubmission.user',
                    'pairedSubmission.song',
                    'pairedSubmission.playlist',
                ])->get(),
        ]);
    }
}
