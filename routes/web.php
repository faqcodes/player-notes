<?php

use Illuminate\Support\Facades\Route;

Route::get('/players', \App\Livewire\PlayersIndex::class)->name('players.index');
Route::redirect('/', '/players');
