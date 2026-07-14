<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\CreatePlayerNoteTool;
use App\Mcp\Tools\GetPlayerNotesTool;
use App\Mcp\Tools\ListPlayersTool;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('Player Notes')]
#[Version('0.0.1')]
#[Instructions('Tools to list players and manage their note history.')]
class PlayerNotesServer extends Server
{
    protected array $tools = [
        ListPlayersTool::class,
        GetPlayerNotesTool::class,
        CreatePlayerNoteTool::class,
    ];

    protected array $resources = [
        //
    ];

    protected array $prompts = [
        //
    ];
}
