<div>
    <h1>Notas de {{ $player->name }}</h1>

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
