<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genresData = [
            'Pop' => [
                'position_x' => 32,
                'position_y' => 12,
            ],
            'Indie Acoustic / Folk' => [
                'position_x' => null,
                'position_y' => null,
            ],
            'Piano / Classical' => [
                'position_x' => 6,
                'position_y' => -15,
            ],
            'Instrumental / Ambient' => [
                'position_x' => -20,
                'position_y' => 20,
            ],
            'Rock' => [
                'position_x' => 40,
                'position_y' => 40,
            ],
            'Electronic' => [
                'position_x' => 64,
                'position_y' => 20,
            ],
            'Lofi / Jazz' => [
                'position_x' => 16,
                'position_y' => 32,
            ],
            'Trap / Hip Hop' => [
                'position_x' => -52,
                'position_y' => 44,
            ],
            'Rock / Metal' => [
                'position_x' => 200,
                'position_y' => 20,
            ],
        ];
        $genresIcons = collect(File::files(storage_path('app/assets/planets')))->map(fn ($file) => $file->getPathname());
        foreach ($genresData as $name => $genreData) {
            $newGenre = Genre::create(['name' => $name, ...$genreData]);
            if (count($genresIcons)) {
                $icon = $genresIcons->where(fn ($icon) => Str::contains($icon, $newGenre->slug.'.'))->first();
                if ($icon) {
                    $newGenre->addMedia($icon)?->preservingOriginal()->toMediaCollection();
                }
            }
        }
    }
}
