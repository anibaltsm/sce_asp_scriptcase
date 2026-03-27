#!/usr/bin/env bash
# Sube el .htaccess de endurecimiento solo para SCE al WAMP vía SMB (recurso C$).
# No guarde contraseñas en este repositorio ni en scripts versionados con credenciales.
#
# Uso (contraseña interactiva):
#   export SMB_SERVER=192.168.2.68
#   export SMB_USER=Administrador
#   export SMB_WORKGROUP=WORKGROUP
#   bash scripts/seguridad/deploy_sce_htaccess_wamp_smb.sh
#
# Uso (variable de entorno, evitar caracteres especiales problemáticos en %):
#   export SMB_PASS='...'
#   bash scripts/seguridad/deploy_sce_htaccess_wamp_smb.sh
#
# Ruta remota por defecto: C:\wamp64\www\SCE\.htaccess

set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
LOCAL_SRC="${ROOT}/seguridad/plantillas/htaccess_SCE_WAMP_raiz_apache24.txt"

SMB_SERVER="${SMB_SERVER:-192.168.2.68}"
SMB_USER="${SMB_USER:-Administrador}"
SMB_WORKGROUP="${SMB_WORKGROUP:-WORKGROUP}"
WIN_REL_SCE_DIR="${WIN_REL_SCE_DIR:-wamp64\\www\\SCE}"

if [[ ! -f "$LOCAL_SRC" ]]; then
  echo "No existe plantilla: $LOCAL_SRC" >&2
  exit 1
fi

SHARE="//${SMB_SERVER}/C\$"
CMD="cd ${WIN_REL_SCE_DIR}; put ${LOCAL_SRC} .htaccess"

if [[ -n "${SMB_PASS:-}" ]]; then
  smbclient "$SHARE" -U "${SMB_USER}%${SMB_PASS}" -W "$SMB_WORKGROUP" -c "$CMD"
else
  smbclient "$SHARE" -U "$SMB_USER" -W "$SMB_WORKGROUP" -c "$CMD"
fi

echo "Listo: subido .htaccess a C:\\${WIN_REL_SCE_DIR//\\\\/\\}\\.htaccess en ${SMB_SERVER}"
echo "Reinicie Apache en WAMP y verifique mod_rewrite y AllowOverride All."
