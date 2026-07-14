<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Player Notes' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-background text-foreground antialiased">
        <header class="border-b border-border bg-card">
            <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-6 py-3">
                <a href="{{ route('players.index') }}" class="text-sm font-semibold tracking-tight">
                    Player Notes
                </a>
                <livewire:user-switcher />
            </div>
        </header>

        <main class="mx-auto max-w-5xl px-6 py-8">
            {{ $slot }}
        </main>
    </body>
</html>
