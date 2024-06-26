<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::factory(2)->unverified()->create();
        User::factory(2)->create();
    }
}
