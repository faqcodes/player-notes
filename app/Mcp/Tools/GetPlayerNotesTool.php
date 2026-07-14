<?php

namespace App\Mcp\Tools;

use App\Contracts\PlayerNoteRepositoryInterface;
use App\Models\Player;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('get-player-notes')]
#[Description('Get the note history for a player.')]
class GetPlayerNotesTool extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'player_id' => ['required', 'integer'],
        ]);

        $player = Player::findOrFail($validated['player_id']);

        $notes = app(PlayerNoteRepositoryInterface::class)
            ->getNotesForPlayer($player, 50);

        $payload = $notes->getCollection()->map(fn ($note) => [
            'date' => $note->created_at?->toIso8601String(),
            'author' => $note->author->name,
            'content' => $note->content,
        ])->values();

        return Response::text($payload->toJson());
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'player_id' => $schema->integer()
                ->description('The id of the player to fetch note history for.')
                ->required(),
        ];
    }
}
