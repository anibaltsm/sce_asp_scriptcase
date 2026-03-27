#!/usr/bin/env python3
"""
Regenera en base_documentacion_2026/ los dos archivos:
  - CONSULTA_IA_TODO_EJEMPLO_PLANTILLA_ATDT.md
  - CONSULTA_IA_TODO_DOCUMENTOS_2025.md

Lee el contenido desde lado_ejemplo/extractos_md y lado_2025/extractos_md
(excluye README.md). Las lineas *Fuente* apuntan a las rutas canonicas
documentos_base_ejemplo/extractos_md y documentos 2025/extractos_md.
"""
from __future__ import annotations

import sys
from pathlib import Path


def repo_root() -> Path:
    # .../CONTRATACION TICS/scripts/thisfile.py -> parents[2] = repo
    return Path(__file__).resolve().parents[2]


def collect_anexos(extractos_dir: Path) -> list[Path]:
    files = sorted(
        p
        for p in extractos_dir.glob("*.md")
        if p.is_file() and p.name.upper() != "README.MD"
    )
    return files


def build_document(
    title: str,
    intro: str,
    lado_dir: Path,
    canon_dir: Path,
) -> str:
    lines: list[str] = [
        f"# {title}\n",
        "\n",
        intro + "\n",
        "\n## Índice de anexos incluidos\n\n",
    ]
    mds = collect_anexos(lado_dir)
    for p in mds:
        lines.append(f"- `{p.name}`\n")
    lines.append("\n---\n")

    for p in mds:
        canon_path = canon_dir / p.name
        body = p.read_text(encoding="utf-8", errors="replace").rstrip() + "\n"
        lines.append(f"\n## Anexo: {p.stem}\n\n")
        lines.append(f"*Fuente:* `{canon_path}`\n\n")
        lines.append(body)
        lines.append("\n---\n")

    return "".join(lines).rstrip() + "\n"


def main() -> int:
    root = repo_root()
    ctics = root / "CONTRATACION TICS"
    base = ctics / "base_documentacion_2026"
    lado_ej = base / "lado_ejemplo" / "extractos_md"
    lado_25 = base / "lado_2025" / "extractos_md"
    canon_ej = ctics / "documentos_base_ejemplo" / "extractos_md"
    canon_25 = ctics / "documentos 2025" / "extractos_md"

    for d, label in ((lado_ej, "lado_ejemplo"), (lado_25, "lado_2025")):
        if not d.is_dir():
            print(f"Error: no existe {d}", file=sys.stderr)
            return 1

    intro_ej = (
        "Texto extraído en Markdown desde `documentos_base_ejemplo/*.docx`. "
        "Las imágenes referenciadas como `media/...` están en "
        "`documentos_base_ejemplo/extractos_md/media/` (nombres con prefijo de documento). "
        "Úsalo como referencia de forma y contenido tipo plantilla para armar **2026**."
    )
    intro_25 = (
        "Texto extraído en Markdown desde `documentos 2025/*.docx`. "
        "Las imágenes referenciadas como `media/...` están en "
        "`documentos 2025/extractos_md/media/`. "
        "Úsalo como línea base de lo ya redactado para comparar con el ejemplo o derivar **2026**."
    )

    out_ej = base / "CONSULTA_IA_TODO_EJEMPLO_PLANTILLA_ATDT.md"
    out_25 = base / "CONSULTA_IA_TODO_DOCUMENTOS_2025.md"

    out_ej.write_text(
        build_document(
            "Paquete completo — documentos de EJEMPLO (plantilla ATDT)",
            intro_ej,
            lado_ej,
            canon_ej,
        ),
        encoding="utf-8",
    )
    out_25.write_text(
        build_document(
            "Paquete completo — documentos elaborados en 2025",
            intro_25,
            lado_25,
            canon_25,
        ),
        encoding="utf-8",
    )

    print(f"Escrito: {out_ej}")
    print(f"Escrito: {out_25}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
