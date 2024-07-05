<?php

namespace App\Listeners;

use App\Events\SubmissionCreated;
use App\Services\SpotifyService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Throwable;

class UpdateSongSpotifyInfo implements ShouldQueue
{
    use InteractsWithQueue;

    public SpotifyService $spotifyService;

    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Create the event listener.
     */
    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    /**
     * Handle the event.
     */
    public function handle(SubmissionCreated $event): void
    {
        try {
            $updatedData = $this->spotifyService
                ->getSong(
                    $event->submission->user,
                    $event->submission->song->spotify_id
                );

            $event->submission->song->update([
                'popularity' => $updatedData['popularity'],
            ]);
        } catch (\Exception $e) {
            $this->release(60);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(SubmissionCreated $event, Throwable $exception): void
    {
        //
    }
}
