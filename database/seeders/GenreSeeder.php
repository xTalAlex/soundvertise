<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genresNames = config('soundvertise.genres');
        $genresIcons = collect(File::files(storage_path('app/assets/planets')))->map(fn ($file) => $file->getPathname());
        $genres = Genre::factory(count($genresNames))->sequence(fn (Sequence $sequence) => ['name' => $genresNames[$sequence->index]])->create();
        if (count($genresIcons)) {
            foreach ($genres as $index => $genre) {
                $genre->addMedia($genresIcons[$index % count($genresIcons)])->preservingOriginal()->toMediaCollection();
            }
        }
    }
}
