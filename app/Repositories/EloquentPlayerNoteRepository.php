<?php

namespace App\Repositories;

use App\Contracts\PlayerNoteRepositoryInterface;
use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentPlayerNoteRepository implements PlayerNoteRepositoryInterface
{
    public function getNotesForPlayer(Player $player, int $perPage = 10): LengthAwarePaginator
    {
        return $player->notes()->with('author')->latest()->paginate($perPage);
    }

    public function createNoteForPlayer(Player $player, User $author, string $content): PlayerNote
    {
        return $player->notes()->create([
            'author_id' => $author->id,
            'content' => $content,
        ]);
    }
}
