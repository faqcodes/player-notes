# MCP como segundo canal sobre el mismo repositorio; autor = user dedicado "AI Agent"

El bonus MCP (paquete oficial `laravel/mcp`, dentro de la misma app) expone tools `list-players`, `get-player-notes` y `create-player-note` que consumen **el mismo `PlayerNoteRepositoryInterface` y la misma constante `MAX_CONTENT_LENGTH`** que el formulario Livewire: un núcleo, dos canales de entrega, cero lógica duplicada.

Como toda `PlayerNote` exige un `User` autor, las notas creadas por el agente se atribuyen a un **user dedicado "AI Agent"** seedeado con el permiso `create player notes`. Rechazamos que el agente actúe como un user humano existente: falsearía la auditoría de quién escribió cada nota. Beneficio extra: quitarle el permiso al user "AI Agent" apaga el canal del agente igual que a un humano.
