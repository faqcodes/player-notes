<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlayerNote>
 */
class PlayerNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->realText(300),
            'author_id' => User::factory(),
            'player_id' => Player::factory(),
        ];
    }
}
