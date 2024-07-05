<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::withWhereHas('playlists')->withWhereHas('songs')->inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'song_id' => $user->songs()->inRandomOrder()->first(),
            'playlist_id' => $user->playlists()->inRandomOrder()->first(),
        ];
    }
}
