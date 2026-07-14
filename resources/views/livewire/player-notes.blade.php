<div class="space-y-6">
    <div class="space-y-3">
        <a
            href="{{ route('players.index') }}"
            class="inline-flex h-8 items-center gap-1.5 rounded-md px-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-muted hover:text-foreground"
        >
            <span aria-hidden="true">&larr;</span> Volver a jugadores
        </a>
        <h1 class="text-2xl font-semibold tracking-tight">Notas de {{ $player->name }}</h1>
    </div>

    @can('create player notes')
        <form wire:submit="save" class="space-y-3 rounded-xl border border-border bg-card p-5 shadow-sm">
            <label for="content" class="block text-sm font-medium">Agregar nota</label>

            <textarea
                id="content"
                wire:model.live="content"
                rows="3"
                placeholder="Escribe una nota sobre este jugador…"
                @class([
                    'w-full resize-y rounded-md border bg-background px-3 py-2 text-sm shadow-xs transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2',
                    'border-input focus-visible:border-ring focus-visible:ring-ring/50' => ! $errors->has('content'),
                    'border-destructive focus-visible:ring-destructive/40' => $errors->has('content'),
                ])
            ></textarea>

            <div class="flex items-center justify-between gap-3">
                <div>
                    @error('content')
                        <p role="alert" class="text-sm text-destructive">{{ $message }}</p>
                    @enderror
                </div>
                <span class="text-xs tabular-nums text-muted-foreground">
                    {{ mb_strlen($content) }}/{{ \App\Models\PlayerNote::MAX_CONTENT_LENGTH }}
                </span>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="inline-flex h-9 items-center justify-center rounded-md bg-primary px-4 text-sm font-medium text-primary-foreground shadow-xs transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring/50 disabled:pointer-events-none disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="save">Guardar</span>
                    <span wire:loading wire:target="save">Guardando…</span>
                </button>
            </div>
        </form>
    @endcan

    @if ($notes->isEmpty())
        <div class="rounded-xl border border-dashed border-border bg-card p-10 text-center">
            <p class="text-sm text-muted-foreground">Este jugador aún no tiene notas.</p>
        </div>
    @else
        <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-border">
                        <th class="whitespace-nowrap px-4 py-3 text-left font-medium text-muted-foreground">Fecha</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left font-medium text-muted-foreground">Autor</th>
                        <th class="px-4 py-3 text-left font-medium text-muted-foreground">Nota</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notes as $note)
                        <tr class="border-b border-border last:border-0 align-top transition-colors hover:bg-muted/50">
                            <td class="whitespace-nowrap px-4 py-3 tabular-nums text-muted-foreground">
                                {{ $note->created_at->format('d-m-Y H:i') }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <span class="inline-flex items-center rounded-md border border-border bg-muted px-2 py-0.5 text-xs font-medium text-muted-foreground">
                                    {{ $note->author->name }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-foreground">{{ $note->content }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $notes->links() }}
    @endif
</div>
