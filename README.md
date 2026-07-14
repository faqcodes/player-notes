# Player Notes

Módulo de historial de notas internas de jugadores para agentes de soporte.

## Requisitos

- Docker Desktop

## Levantar el proyecto

```bash
git clone <url-del-repo> player-notes
cd player-notes
cp .env.example .env
./vendor/bin/sail up -d
```

Al levantar, el servicio `migrate` corre `php artisan migrate --force --seed` en cuanto la base de datos Postgres queda `healthy`: migraciones y datos de demo (roles, users, players y notas) quedan cargados solos, sin pasos manuales.

Listo: la app queda en http://localhost con datos de demo cargados.

## Demo

En entorno local no hay pantalla de login: la app auto-loguea a **Admin Demo** y expone un dropdown de usuario activo (arriba a la derecha) para cambiar entre los dos users demo:

- **Admin Demo** (`admin@demo.test`) — rol `admin`: puede leer el historial y agregar notas nuevas.
- **Viewer Demo** (`viewer@demo.test`) — rol `viewer`: solo puede leer el historial; el formulario de nota no está disponible para este rol.

Recorrido:

1. Entrar a `/players` — lista de jugadores.
2. Clic en un jugador — historial de notas (autor, fecha, contenido), paginado.
3. Con **Admin Demo** activo, agregar una nota: valida que no esté vacía y que no supere el máximo de caracteres (con contador en vivo), y al guardar refresca el listado automáticamente sin recargar la página.

## Arquitectura

- **Patrón Repositorio**: `App\Contracts\PlayerNoteRepositoryInterface` define el contrato (`getNotesForPlayer`, `createNoteForPlayer`); `App\Repositories\EloquentPlayerNoteRepository` es la implementación Eloquent; el binding vive en `App\Providers\AppServiceProvider`. El objetivo es que tanto la UI Livewire como el servidor MCP consuman el mismo repositorio, sin lógica duplicada.
- **Autorización con spatie/laravel-permission**: se eligió el estándar del ecosistema Laravel en vez de una Policy nativa, para tener vocabulario conocido por cualquier equipo y quedar extensible sin refactor si aparecen más roles o permisos. Roles: `admin` (puede crear notas) y `viewer` (solo lee); permiso: `create player notes`. Detalle en `docs/adr/0001-spatie-permission-para-roles.md`.
- **Modelo de dominio**:
  - `Player`: jugador de la plataforma sobre el que se dejan notas. Solo se consulta en este alcance (no se crea ni edita desde la UI). Tiene muchas `PlayerNote` (`notes()`).
  - `PlayerNote`: nota interna e inmutable (se crea y se lista; no se edita ni borra). Pertenece a un `Player` (`player()`) y a un `User` autor (`author()`).
  - `User`: agente de soporte, autor de notas (`authoredNotes()`). Tiene rol `admin` o `viewer`.
- Más contexto de dominio en `CONTEXT.md` y decisiones en `docs/adr/`.

## Tests

```bash
./vendor/bin/sail artisan test
```

Cubren:

- que un admin puede crear una nota y queda guardada en la base de datos;
- que se rechaza una nota vacía;
- que se rechaza una nota que supera el largo máximo permitido;
- que un viewer no puede crear una nota (403 del lado del servidor, no solo oculto en la UI).

## MCP (bonus)

El proyecto expone un servidor MCP (paquete oficial `laravel/mcp`) en el endpoint `/mcp`, con 3 tools que reutilizan el mismo repositorio y la misma constante de largo máximo que usa el formulario Livewire:

- `list-players` — lista todos los jugadores con su id.
- `get-player-notes` — historial de notas de un jugador (`player_id`).
- `create-player-note` — crea una nota nueva para un jugador (`player_id`, `content`).

Las notas creadas por este canal quedan atribuidas a un user dedicado **"AI Agent"** (no a un agente humano existente), para no falsear la auditoría de quién escribió cada nota; basta con quitarle el permiso `create player notes` a ese user para apagar el canal del agente. Detalle en `docs/adr/0002-mcp-segundo-canal-autor-ai-agent.md`.

Para conectar un cliente MCP con transporte HTTP, un snippet de configuración típico:

```json
{
  "mcpServers": {
    "player-notes": {
      "url": "http://localhost/mcp"
    }
  }
}
```

El endpoint `/mcp` no lleva autenticación por ser un demo local; en producción habría que autenticarlo (OAuth/token) y no exponerlo abierto.
