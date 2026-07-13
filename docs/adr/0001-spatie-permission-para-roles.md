# spatie/laravel-permission en vez de Policy nativa

El alcance actual (2 roles, 1 permiso) se cubría con una Policy nativa y una columna `role`, que era la solución más chica. Elegimos **spatie/laravel-permission** por ser el estándar del ecosistema Laravel para autorización basada en roles: vocabulario conocido por cualquier equipo, y extensible sin refactor cuando aparezcan más roles o permisos granulares. Roles: `admin` (crea notas), `viewer` (solo lee); permiso: `create player notes`.

## Consequences

- El chequeo en UI/backend es `$user->can('create player notes')` vía spatie, no una Policy propia.
- El seeder debe crear roles y permiso antes que los users demo.
