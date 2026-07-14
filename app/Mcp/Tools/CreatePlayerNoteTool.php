<?php

namespace App\Mcp\Tools;

use App\Contracts\PlayerNoteRepositoryInterface;
use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('create-player-note')]
#[Description('Create a new note for a player, attributed to the AI Agent.')]
class CreatePlayerNoteTool extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'player_id' => ['required', 'integer'],
            'content' => ['required', 'string', 'max:' . PlayerNote::MAX_CONTENT_LENGTH],
        ]);

        $agent = User::where('email', 'agent@demo.test')->firstOrFail();
        abort_unless($agent->can('create player notes'), 403);

        $player = Player::findOrFail($validated['player_id']);

        $note = app(PlayerNoteRepositoryInterface::class)
            ->createNoteForPlayer($player, $agent, $validated['content']);

        return Response::text("Note {$note->id} created for player {$player->name}.");
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
                ->description('The id of the player to add a note to.')
                ->required(),
            'content' => $schema->string()
                ->description('The note content, max ' . PlayerNote::MAX_CONTENT_LENGTH . ' characters.')
                ->max(PlayerNote::MAX_CONTENT_LENGTH)
                ->required(),
        ];
    }
}
