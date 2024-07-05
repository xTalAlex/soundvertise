<?php

namespace Database\Factories;

use App\Models\BlacklistItem;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BlacklistItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlacklistItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $blacklistableType = $this->faker->randomElement([User::class, Playlist::class, Song::class]);

        do {
            $blacklistable = $blacklistableType::inRandomOrder()->first();
            $user = User::inRandomOrder()->first();

            if ($blacklistableType === User::class && $blacklistable) {
                $user = User::inRandomOrder()->whereKeyNot($blacklistable->id)->first();
            }

            $exists = BlacklistItem::where('user_id', $user?->getKey())
                ->where('blacklistable_id', $blacklistable?->getKey())
                ->where('blacklistable_type', $blacklistable?->getMorphClass())
                ->exists();
        } while ($exists || ! $user || ! $blacklistable);

        return [
            'user_id' => $user->getKey(),
            'blacklistable_id' => $blacklistable->getKey(),
            'blacklistable_type' => $blacklistable->getMorphClass(),
        ];
    }
}
