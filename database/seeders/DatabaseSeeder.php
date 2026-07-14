<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Idempotent: skips if the database was already seeded, so re-running
     * `migrate --seed` (e.g. on every `docker compose up`) never duplicates data.
     */
    public function run(): void
    {
        if (Player::exists()) {
            return;
        }

        $this->call([RolesAndUsersSeeder::class, PlayerSeeder::class, PlayerNoteSeeder::class]);
    }
}
