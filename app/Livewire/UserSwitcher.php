<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserSwitcher extends Component
{
    public function switchTo(int $userId): void
    {
        abort_unless(app()->environment(['local', 'testing']), 403);

        $user = User::whereIn('email', ['admin@demo.test', 'viewer@demo.test'])->findOrFail($userId);
        Auth::login($user);
        $this->js('window.location.reload()');
    }

    public function render(): View
    {
        return view('livewire.user-switcher', [
            'users' => User::whereIn('email', ['admin@demo.test', 'viewer@demo.test'])->get(),
        ]);
    }
}
