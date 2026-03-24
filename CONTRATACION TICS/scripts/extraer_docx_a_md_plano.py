#!/usr/bin/env python3
"""
Convierte .docx a Markdown (GFM) con Pandoc, estructura plana:
  <salida>/*.md
  <salida>/media/<nombre_docx>__imageN.ext
Sustituye etiquetas <img> por sintaxis ![alt](media/...).
"""
from __future__ import annotations

import argparse
import re
import shutil
import subprocess
import sys
import tempfile
from pathlib import Path


def img_to_markdown(md: str) -> str:
    def repl(m: re.Match) -> str:
        tag = m.group(0)
        src_m = re.search(r'src\s*=\s*"([^"]+)"', tag, re.I)
        if not src_m:
            return tag
        src = src_m.group(1)
        alt_m = re.search(r'alt\s*=\s*"([^"]*)"', tag, re.I)
        alt = alt_m.group(1) if alt_m else ""
        return f"![{alt}]({src})"

    return re.sub(r"<img\b[^>]+/?>", repl, md, flags=re.I)


def convert_docx(docx: Path, out_dir: Path, out_media: Path) -> None:
    base = docx.stem
    md_path = out_dir / f"{base}.md"

    with tempfile.TemporaryDirectory(prefix=f"pandoc_{base}_") as tmp:
        tmp_path = Path(tmp)
        subprocess.run(
            [
                "pandoc",
                str(docx),
                "-f",
                "docx",
                "-t",
                "gfm",
                "--wrap=none",
                f"--extract-media={tmp_path}",
                "-o",
                str(md_path),
            ],
            check=True,
        )
        tmp_media = tmp_path / "media"
        text = md_path.read_text(encoding="utf-8", errors="replace")

        if tmp_media.is_dir():
            for img in sorted(tmp_media.iterdir()):
                if not img.is_file():
                    continue
                old = img.name
                new = f"{base}__{old}"
                shutil.copy2(img, out_media / new)
                text = re.sub(
                    r'[^\s"<>]*/media/' + re.escape(old) + r'(?=["\s>)])',
                    f"media/{new}",
                    text,
                )
                text = text.replace(f"media/{old}", f"media/{new}")

        text = img_to_markdown(text)
        # Pandoc/Word a veces duplica la misma figura (HTML + MD o doble referencia)
        text = re.sub(
            r"(\!\[[^\]]*\]\([^)]+\))(?:\s*\1)+",
            r"\1",
            text,
        )
        text = re.sub(r"\n{3,}", "\n\n", text)
        md_path.write_text(text, encoding="utf-8")


def prepare_out_dir(out_dir: Path) -> None:
    out_dir.mkdir(parents=True, exist_ok=True)
    for p in out_dir.iterdir():
        if p.name == "media":
            continue
        if p.is_dir():
            shutil.rmtree(p)
        elif p.suffix.lower() == ".md" and p.name.upper() != "README.MD":
            p.unlink()


def main() -> int:
    ap = argparse.ArgumentParser()
    ap.add_argument("origen", type=Path, help="Carpeta con archivos .docx")
    ap.add_argument(
        "salida",
        type=Path,
        nargs="?",
        help="Carpeta de salida (por defecto: origen/extractos_md)",
    )
    args = ap.parse_args()
    origen: Path = args.origen.resolve()
    salida: Path = (args.salida or (origen / "extractos_md")).resolve()

    if not origen.is_dir():
        print(f"No existe carpeta: {origen}", file=sys.stderr)
        return 1

    docxs = sorted(origen.glob("*.docx"))
    if not docxs:
        print(f"No hay .docx en {origen}", file=sys.stderr)
        return 1

    prepare_out_dir(salida)
    media_dir = salida / "media"
    if media_dir.exists():
        shutil.rmtree(media_dir)
    media_dir.mkdir(parents=True)

    for docx in docxs:
        print(docx.name)
        convert_docx(docx, salida, media_dir)

    print(f"Listo: {len(docxs)} documentos -> {salida}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
