#!/usr/bin/env python3
"""
Genera CONSOLIDADO_EJEMPLO_VS_2025.md en base_alimentacion_ATDT_2026/
a partir de los extractos Markdown planos (ejemplo vs documentos 2025).
Reescribe rutas media/ a relativas desde la carpeta de salida.
"""
from __future__ import annotations

import re
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
EJEMPLO = ROOT / "documentos_base_ejemplo" / "extractos_md"
Y2025 = ROOT / "documentos 2025" / "extractos_md"
OUT_DIR = ROOT / "base_alimentacion_ATDT_2026"
OUT_FILE = OUT_DIR / "CONSOLIDADO_EJEMPLO_VS_2025.md"

# Relativos desde OUT_DIR (base_alimentacion_ATDT_2026/)
PREFIX_EJEMPLO = "../documentos_base_ejemplo/extractos_md/media/"
PREFIX_2025 = "../documentos 2025/extractos_md/media/"

# Orden: (codigo, titulo, archivo_ejemplo, archivo_2025)
ANEXOS: list[tuple[str, str, str | None, str | None]] = [
    ("01", "Justificación", "01_Anexo_Justificacion_ADTD_Ejemplo_2025.md", "01_Anexo_Justificacion_ADTD_2025.md"),
    ("02", "Anexo técnico", "02_Anexo_Tecnico_ATDT_Ejemplo_2025.md", "02_Anexo_Tecnico_ATDT_2025.md"),
    ("03", "Estudio de mercado", "03_Anexo_Estudio_Mercado_ATDT_Ejemplo_2025.md", None),
    ("04", "Diagrama conceptual", "04_Anexo_Diagrama_Conceptual_ATDT_Ejemplo_2025.md", "04_Anexo_Diagrama_Conceptual_ATDT_2025.md"),
    ("07", "Calendario del servicio", None, "07_Anexo_Calendario_ATDT_2025.md"),
    ("14", "CompraNet", "14_Anexo_COMPRANET_ATDT_Ejemplo_2025.md", "14_Anexo_COMPRANET_ATDT_2025.md"),
]


def rewrite_media(text: str, prefix: str) -> str:
    """Sustituye media/ARCHIVO por prefix+ARCHIVO en enlaces Markdown e img."""
    return re.sub(
        r"(?<![\w/])media/",
        prefix,
        text,
    )


def read_md(folder: Path, name: str | None) -> str | None:
    if not name:
        return None
    p = folder / name
    if not p.is_file():
        return None
    return p.read_text(encoding="utf-8", errors="replace")


def main() -> int:
    if not EJEMPLO.is_dir() or not Y2025.is_dir():
        print("Faltan carpetas extractos_md de ejemplo o 2025.", file=sys.stderr)
        return 1

    OUT_DIR.mkdir(parents=True, exist_ok=True)

    parts: list[str] = [
        "# Consolidado: anexos ejemplo (plantilla) vs versión 2025\n\n",
        "Documento generado automáticamente para servir de base a la documentación **2026**. ",
        "Las rutas de imagen son relativas a esta carpeta (`base_alimentacion_ATDT_2026/`).\n\n",
        "---\n\n",
    ]

    for codigo, titulo, fej, f25 in ANEXOS:
        parts.append(f"## Anexo {codigo} — {titulo}\n\n")

        bloque_ej = read_md(EJEMPLO, fej)
        bloque_25 = read_md(Y2025, f25)

        if bloque_ej:
            parts.append("### Ejemplo (plantilla)\n\n")
            parts.append(rewrite_media(bloque_ej, PREFIX_EJEMPLO))
            parts.append("\n\n")
        else:
            parts.append("### Ejemplo (plantilla)\n\n")
            parts.append(
                "*No hay archivo equivalente en `documentos_base_ejemplo/extractos_md/` para este anexo.*\n\n"
            )

        if bloque_25:
            parts.append("### Versión 2025\n\n")
            parts.append(rewrite_media(bloque_25, PREFIX_2025))
            parts.append("\n\n")
        else:
            parts.append("### Versión 2025\n\n")
            if codigo == "03":
                parts.append(
                    "*No hay análogo en `documentos 2025/extractos_md/`; incorporar en 2026 si aplica.*\n\n"
                )
            else:
                parts.append(
                    "*No hay archivo equivalente en `documentos 2025/extractos_md/` para este anexo.*\n\n"
                )

        parts.append("---\n\n")

    OUT_FILE.write_text("".join(parts), encoding="utf-8")
    print(f"Escrito: {OUT_FILE} ({OUT_FILE.stat().st_size} bytes)")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
