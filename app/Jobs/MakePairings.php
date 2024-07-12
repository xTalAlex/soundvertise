<?php

namespace App\Jobs;

use App\Models\Pairing;
use App\Models\Submission;
use App\Services\SubmissionService;
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
    ) {}

    /**
     * Execute the job.
     */
    public function handle(SubmissionService $submissionService): void
    {
        $pairableSubmissions = $submissionService->pairableSubmissionsFor($this->submission);

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
