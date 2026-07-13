<?php

namespace App\Providers;

use App\Contracts\PlayerNoteRepositoryInterface;
use App\Repositories\EloquentPlayerNoteRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PlayerNoteRepositoryInterface::class, EloquentPlayerNoteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
