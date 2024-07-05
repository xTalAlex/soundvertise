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
        $pairableSubmissions = Submission::with('song', 'playlist')
            // submission made by a different user
            ->where('user_id', '!=', $this->submission->user_id)
            // having their playlist genre matching with submitted song genre
            //->whereHas('playlist', fn ($query) => $query->where('genre_id', $this->submission->song->genre_id))
            // and having their song genre matching with submitted playlis genre
            //->whereHas('song', fn ($query) => $query->where('genre_id', $this->submission->playlist->genre_id))
            // having matching playlist generes
            ->whereHas('playlist', fn ($query) => $query->where('genre_id', $this->submission->playlist->genre_id))
            ->get();

        //chunk submissions into smaller jobs

        foreach ($pairableSubmissions as $submission) {
            // create pairing for the submission user
            $pairing = Pairing::firstOrCreate([
                'submission_id' => $this->submission->id,
                'paired_submission_id' => $submission->id,
            ], []);
            // create pairing for the other submission user
            $otherPairing = Pairing::firstOrCreate([
                'submission_id' => $submission->id,
                'paired_submission_id' => $this->submission->id,
            ], []);
        }
    }
}
