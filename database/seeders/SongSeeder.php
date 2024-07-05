<?php

namespace Database\Seeders;

use App\Models\Song;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spotifySongIds = [
            '5CjwXdq5Z73Va0XCPFG5Aq',
            '4hxSivlAPWlFJ4lZhNz3AD',
            '1zs0BxFFLfbJQTSo84rkhy',
            '6bJL4yIWjL0z7fq8qp0T5A',
        ];

        Song::factory(count($spotifySongIds))
            ->sequence(fn (Sequence $sequence) => ['spotify_id' => $spotifySongIds[$sequence->index]]
            )
            ->create();
    }
}
