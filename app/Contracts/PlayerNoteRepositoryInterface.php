<?php

namespace App\Contracts;

use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface PlayerNoteRepositoryInterface
{
    public function getNotesForPlayer(Player $player, int $perPage = 10): LengthAwarePaginator;

    public function createNoteForPlayer(Player $player, User $author, string $content): PlayerNote;
}
