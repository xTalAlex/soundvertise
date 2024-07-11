<?php

namespace App\Jobs;

use App\Models\Pairing;
use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MakePairings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Submission $submission,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        // playlists containing the submitted song
        $playlistIds = Submission::query()
            ->whereHas('pairings', fn ($query) => $query
                ->ongoingMatches()
                ->whereHas('pairedSubmission', fn ($query) => $query
                    ->where('song_id', $this->submission->song_id)
                )
            )->get()->pluck('playlist_id');

        // songs already added to the submitted playlist
        $songIds = Submission::query()
            ->whereHas('pairings', fn ($query) => $query
                ->ongoingMatches()
                ->whereHas('pairedSubmission', fn ($query) => $query
                    ->where('playlist_id', $this->submission->playlist_id)
                )
            )->get()->pluck('song_id');

        $pairableSubmissions = Submission::active()->with('song', 'playlist')
            // submission made by a different user
            ->where('user_id', '!=', $this->submission->user_id)
            // exclude active matches
            ->whereNotIn('song_id', $songIds)->whereNotIn('playlist_id', $playlistIds)
            // having matching playlist generes
            ->whereHas('playlist', fn ($query) => $query->where('genre_id', $this->submission->playlist->genre_id))
            ->get();

        //chunk submissions into smaller jobs

        foreach ($pairableSubmissions as $otherSubmission) {
            // create pairing for the submission user
            $pairing = Pairing::firstOrCreate([
                'submission_id' => $this->submission->id,
                'paired_submission_id' => $otherSubmission->id,
            ], []);
            // create pairing for the other submission user
            $otherPairing = Pairing::firstOrCreate([
                'submission_id' => $otherSubmission->id,
                'paired_submission_id' => $this->submission->id,
            ], []);
        }
    }
}
