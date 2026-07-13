<div>
    <h1>Notas de {{ $player->name }}</h1>

    @can('create player notes')
        <form wire:submit="save">
            <label for="content">Agregar nota</label>
            <textarea id="content" wire:model.live="content" rows="3"></textarea>
            <span>{{ mb_strlen($content) }}/{{ \App\Models\PlayerNote::MAX_CONTENT_LENGTH }}</span>
            @error('content') <p role="alert">{{ $message }}</p> @enderror
            <button type="submit">Guardar</button>
        </form>
    @endcan

    @if ($notes->isEmpty())
        <p>Este jugador aún no tiene notas.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Autor</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notes as $note)
                    <tr>
                        <td>{{ $note->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $note->author->name }}</td>
                        <td>{{ $note->content }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $notes->links() }}
    @endif
</div>
