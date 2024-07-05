<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::whereNotNull('spotify_id')->inRandomOrder()->first();

        return [
            'name' => fake()->words(4, true),
            'spotify_id' => Str::random(22),
            'user_id' => $user->id,
        ];
    }
}
