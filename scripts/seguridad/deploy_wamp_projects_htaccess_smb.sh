#!/usr/bin/env bash
# Sube el mismo .htaccess de endurecimiento Scriptcase a varias carpetas bajo C:\wamp64\www\ vía SMB (C$).
# No guarde contraseñas en el repositorio.
#
# Uso:
#   cd /opt/sce_asp_scriptcase
#   export SMB_SERVER=192.168.2.68 SMB_USER=Administrador SMB_WORKGROUP=WORKGROUP
#   export SMB_PROJECTS='convenios,cursos,diplomados,evaluaciones,tesis'
#   read -s -p "Contraseña: " SMB_PASS; echo; export SMB_PASS
#   bash scripts/seguridad/deploy_wamp_projects_htaccess_smb.sh
#
# Variables opcionales:
#   WIN_WWW_BASE   ruta relativa a C:\ (por defecto wamp64\\www)
#   SMB_PROJECTS   lista separada por comas de nombres de carpeta bajo WIN_WWW_BASE

set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
LOCAL_SRC="${ROOT}/seguridad/plantillas/htaccess_SCE_WAMP_raiz_apache24.txt"

SMB_SERVER="${SMB_SERVER:-192.168.2.68}"
SMB_USER="${SMB_USER:-Administrador}"
SMB_WORKGROUP="${SMB_WORKGROUP:-WORKGROUP}"
WIN_WWW_BASE="${WIN_WWW_BASE:-wamp64\\www}"
SMB_PROJECTS="${SMB_PROJECTS:-convenios,cursos,diplomados,evaluaciones,tesis}"

if [[ ! -f "$LOCAL_SRC" ]]; then
  echo "No existe plantilla: $LOCAL_SRC" >&2
  exit 1
fi

SHARE="//${SMB_SERVER}/C\$"

smb_put() {
  local rel="$1"
  local cmd="cd ${rel}; put ${LOCAL_SRC} .htaccess"
  if [[ -n "${SMB_PASS:-}" ]]; then
    smbclient "$SHARE" -U "${SMB_USER}%${SMB_PASS}" -W "$SMB_WORKGROUP" -c "$cmd"
  else
    smbclient "$SHARE" -U "$SMB_USER" -W "$SMB_WORKGROUP" -c "$cmd"
  fi
}

IFS=',' read -ra PROJS <<< "$SMB_PROJECTS"
for raw in "${PROJS[@]}"; do
  proj="${raw#"${raw%%[![:space:]]*}"}"
  proj="${proj%"${proj##*[![:space:]]}"}"
  [[ -z "$proj" ]] && continue
  REL="${WIN_WWW_BASE}\\${proj}"
  echo ">>> Subiendo .htaccess a C:\\${REL//\\\\/\\}\\ ..."
  smb_put "$REL"
done

echo "Listo. Reinicie Apache en WAMP y verifique mod_rewrite y AllowOverride All."
