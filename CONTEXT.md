# Player Notes

Módulo de soporte para una plataforma de juego: los agentes de soporte dejan notas internas sobre los jugadores para tener historial al atenderlos.

## Language

**Jugador (Player)**:
Cliente de la plataforma sobre el cual se dejan notas. Entidad propia (`Player`), NO es un registro de `users`. En el alcance de este módulo solo se consulta; no se crea ni edita desde la UI.
_Avoid_: usuario, user, cliente

**Agente de soporte (User)**:
Persona de back-office que atiende jugadores. Es el `User` de Laravel y el único autor posible de una nota. Tiene rol **admin** (puede crear notas) o **viewer** (solo lee el historial).
_Avoid_: operador, usuario (como nombre de rol)

**Nota de jugador (PlayerNote)**:
Observación interna escrita por un Agente de soporte sobre un Jugador. Inmutable en este alcance (se crea y se lista; no se edita ni borra). Tiene fecha, autor y contenido.
_Avoid_: comentario, observación, mensaje

## Relationships

- Un **Jugador** tiene muchas **Notas de jugador**
- Un **Agente de soporte** es autor de muchas **Notas de jugador**
- Una **Nota de jugador** pertenece a exactamente un Jugador y un autor

## Example dialogue

> **Dev:** ¿Un jugador puede escribir una nota sobre sí mismo?
> **Experto:** No. Los jugadores no tienen acceso al sistema — las notas son internas. Solo un agente de soporte escribe notas.
> **Dev:** ¿Y un agente puede ser jugador?
> **Experto:** No en este dominio: users y players son poblaciones separadas. El agente vive en `users`; el jugador es cliente, vive en `players`.
> **Dev:** ¿Las notas se editan?
> **Experto:** No. Es un historial: se agrega y se lee. Si algo quedó mal, se agrega otra nota.
