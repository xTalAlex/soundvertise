<?php

namespace Database\Seeders;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereHas('playlists')->whereHas('songs')->whereDoesntHave('submissions', fn ($query) => $query->active())->get();

        foreach ($users as $user) {
            Submission::factory()->create([
                'user_id' => $user->id,
                'song_id' => $user->songs()->inRandomOrder()->first(),
                'playlist_id' => $user->playlists()->inRandomOrder()->first(),
            ]);
        }
    }
}
