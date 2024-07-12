<?php

namespace App\Services;

use App\Models\Pairing;
use App\Models\Submission;

class SubmissionService
{
    public function pairableSubmissionsFor(Submission $submission)
    {
        // playlists containing the submitted song
        $playlistIds = Pairing::with('pairedSubmission')->ongoingMatch()
            ->whereHas('submission', fn ($query) => $query->where('song_id', $submission->song_id))
            ->get()->pluck('pairedSubmission.*.playlist_id');

        // songs already added to the submitted playlist
        $songIds = Pairing::with('pairedSubmission')->ongoingMatch()
            ->whereHas('submission', fn ($query) => $query->where('playlist_id', $submission->playlist_id))
            ->get()->pluck('pairedSubmission.*.song_id');

        $pairableSubmissions = Submission::active()
            // submission made by a different user
            ->where('user_id', '!=', $submission->user_id)
            // exclude active matches
            ->whereNotIn('song_id', $songIds)->whereNotIn('playlist_id', $playlistIds)
            // having matching playlist generes
            ->whereHas('playlist', fn ($query) => $query->where('genre_id', $submission->playlist->genre_id))
            ->get();

        return $pairableSubmissions;
    }
}
