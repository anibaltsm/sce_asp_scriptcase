# Skills y guías de herramientas (proyecto)

Aquí se documentan **habilidades y flujos** que quieres que el asistente use de forma consistente. Cada tema puede tener:

- **`herramientas/*.md`** — Guía legible para humanos (comandos, opciones, cuándo usar qué).
- **`.cursor/skills/<nombre>/SKILL.md`** — Skill de Cursor (el agente lo descubre por la descripción y aplica el flujo).

## Índice de guías

| Guía | Descripción breve |
|------|-------------------|
| [herramientas/pdf-docx-markdown.md](herramientas/pdf-docx-markdown.md) | Extraer texto de PDF, convertir Word ↔ Markdown, imágenes embebidas, script del repo |

## Añadir una guía nueva

1. Crea `skills/herramientas/<tema>.md` con comandos y advertencias.
2. Si quieres que Cursor lo use solo: añade `.cursor/skills/<nombre>/SKILL.md` con frontmatter `name` y `description` (ver skill existente como plantilla).

## Relación con scripts del repo

Algunas guías enlazan scripts ya versionados (por ejemplo bajo `CONTRATACION TICS/scripts/`). No dupliques lógica: la guía describe **cuándo** y **cómo** invocarlos.
