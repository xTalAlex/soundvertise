<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Playlist;
use Illuminate\Database\Seeder;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Playlist::factory(5)
            ->withGenre(Genre::inRandomOrder()->first())
            ->create();
    }
}
