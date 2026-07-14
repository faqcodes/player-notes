<div class="space-y-6">
    <div class="space-y-1">
        <h1 class="text-2xl font-semibold tracking-tight">Jugadores</h1>
        <p class="text-sm text-muted-foreground">Selecciona un jugador para ver su historial de notas.</p>
    </div>

    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-border">
                    <th class="px-4 py-3 text-left font-medium text-muted-foreground">Jugador</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($players as $player)
                    <tr class="border-b border-border last:border-0 transition-colors hover:bg-muted/50">
                        <td class="px-4 py-3">
                            <a
                                href="{{ route('players.show', $player) }}"
                                class="font-medium text-foreground underline-offset-4 hover:underline"
                            >
                                {{ $player->name }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
