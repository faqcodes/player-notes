<?php

namespace App\Livewire;

use App\Contracts\PlayerNoteRepositoryInterface;
use App\Models\Player;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class PlayerNotes extends Component
{
    use WithPagination;

    public Player $player;

    public function render(PlayerNoteRepositoryInterface $repository): View
    {
        return view('livewire.player-notes', [
            'notes' => $repository->getNotesForPlayer($this->player),
        ]);
    }
}
