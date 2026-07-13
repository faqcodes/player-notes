<?php

use Illuminate\Support\Facades\Route;

Route::get('/players', \App\Livewire\PlayersIndex::class)->name('players.index');
Route::get('/players/{player}', \App\Livewire\PlayerNotes::class)->name('players.show');
Route::redirect('/', '/players');
