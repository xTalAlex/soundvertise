<?php

namespace Database\Seeders;

use App\Models\BlacklistItem;
use Illuminate\Database\Seeder;

class BlacklistItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlacklistItem::factory(5)->create();
    }
}
