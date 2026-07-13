<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Database\Seeder;

class PlayerNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = collect(['Carla Soto', 'Jorge Ramírez', 'Andrea Pino'])
            ->map(fn (string $name) => User::factory()->create(['name' => $name]));

        Player::orderBy('id')->skip(1)->get()->each(function (Player $player) use ($authors) {
            PlayerNote::factory()
                ->count(fake()->numberBetween(5, 25))
                ->create([
                    'player_id' => $player->id,
                    'author_id' => fn () => $authors->random()->id,
                ]);
        });
    }
}
