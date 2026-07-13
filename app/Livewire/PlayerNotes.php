<?php

namespace App\Livewire;

use App\Contracts\PlayerNoteRepositoryInterface;
use App\Models\Player;
use App\Models\PlayerNote;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class PlayerNotes extends Component
{
    use WithPagination;

    public Player $player;

    public string $content = '';

    /** @return array<string, array<int, string>> */
    protected function rules(): array
    {
        return ['content' => ['required', 'string', 'max:' . PlayerNote::MAX_CONTENT_LENGTH]];
    }

    /** @return array<string, string> */
    protected function messages(): array
    {
        return [
            'content.required' => 'La nota no puede estar vacía.',
            'content.max' => 'La nota no puede superar :max caracteres.',
        ];
    }

    public function save(PlayerNoteRepositoryInterface $repository): void
    {
        abort_unless(Auth::user()?->can('create player notes'), 403);
        $this->validate();
        $repository->createNoteForPlayer($this->player, Auth::user(), $this->content);
        $this->reset('content');
        $this->resetPage();
    }

    public function render(PlayerNoteRepositoryInterface $repository): View
    {
        return view('livewire.player-notes', [
            'notes' => $repository->getNotesForPlayer($this->player),
        ]);
    }
}
