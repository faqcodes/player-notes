<?php

use App\Livewire\PlayerNotes;
use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use Database\Seeders\RolesAndUsersSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(RolesAndUsersSeeder::class);
    $this->player = Player::factory()->create();
    $this->admin = User::where('email', 'admin@demo.test')->firstOrFail();
    $this->viewer = User::where('email', 'viewer@demo.test')->firstOrFail();
});

it('stores a note in the database when an admin creates it', function (): void {
    Livewire::actingAs($this->admin)
        ->test(PlayerNotes::class, ['player' => $this->player])
        ->set('content', 'Player requested account limits.')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('player_notes', [
        'player_id' => $this->player->id,
        'author_id' => $this->admin->id,
        'content' => 'Player requested account limits.',
    ]);
});

it('rejects an empty note', function (): void {
    Livewire::actingAs($this->admin)
        ->test(PlayerNotes::class, ['player' => $this->player])
        ->set('content', '')
        ->call('save')
        ->assertHasErrors(['content' => 'required']);

    expect(PlayerNote::count())->toBe(0);
});

it('rejects a note longer than the maximum length', function (): void {
    Livewire::actingAs($this->admin)
        ->test(PlayerNotes::class, ['player' => $this->player])
        ->set('content', str_repeat('a', PlayerNote::MAX_CONTENT_LENGTH + 1))
        ->call('save')
        ->assertHasErrors(['content' => 'max']);

    expect(PlayerNote::count())->toBe(0);
});

it('forbids a viewer from creating a note server-side', function (): void {
    Livewire::actingAs($this->viewer)
        ->test(PlayerNotes::class, ['player' => $this->player])
        ->set('content', 'Should not be saved.')
        ->call('save')
        ->assertStatus(403);

    expect(PlayerNote::count())->toBe(0);
});
