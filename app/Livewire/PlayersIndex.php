<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class PlayersIndex extends Component
{
    public function render(): View
    {
        return view('livewire.players-index', [
            'players' => \App\Models\Player::orderBy('name')->get(),
        ]);
    }
}
