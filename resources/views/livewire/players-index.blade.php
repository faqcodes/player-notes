<div>
    <h1>Jugadores</h1>

    <table>
        <thead>
            <tr>
                <th>Jugador</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($players as $player)
                <tr>
                    <td><a href="{{ route('players.show', $player) }}">{{ $player->name }}</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
