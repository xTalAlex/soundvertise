<?php

namespace App\Jobs;

use App\Models\Pairing;
use App\Models\Submission;
use App\Services\PairingService;
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
    public function handle(PairingService $pairingService): void
    {
        $pairableSubmissions = $pairingService->pairableSubmissionsFor($this->submission);

        //chunk submissions into smaller jobs

        foreach ($pairableSubmissions as $pairedSubmission) {
            // create pairing for the submission user
            $pairingService->create($this->submission, $pairedSubmission);
        }
    }
}
