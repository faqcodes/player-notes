<?php

use App\Mcp\Servers\PlayerNotesServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp', PlayerNotesServer::class);
