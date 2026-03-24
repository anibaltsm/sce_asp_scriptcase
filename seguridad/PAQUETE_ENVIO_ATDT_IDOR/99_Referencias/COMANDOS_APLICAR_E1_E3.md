# Comandos unificados para aplicar E1 + E3 (produccion)

## 1) Ejecutar aplicacion automatizada (recomendado)

```bash
sudo bash "/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/99_Referencias/aplicar_hardening_e1e3.sh"
```

## 2) Verificar estado rapido

```bash
/opt/lampp/bin/httpd -t
python3 - <<'PY'
from pathlib import Path
p = Path("/opt/lampp/etc/httpd.conf")
needle='Include "/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/99_Referencias/rate_limit_login_apache.conf"'
print("include_e1=", needle in p.read_text(errors='ignore'))
PY
sudo cat /etc/cron.d/idor_sc_log_alertas
ls -lh "/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/04_Anexos/EVIDENCIAS/" | python3 - <<'PY'
import sys
for l in sys.stdin:
    if 'alertas_sc_log' in l or 'hardening_e1e3' in l:
        print(l.rstrip())
PY
```

## 3) Evidencia a insertar en informe (Anexo H/F)

- `04_Anexos/EVIDENCIAS/hardening_e1e3_aplicado_*.log`
- `04_Anexos/EVIDENCIAS/alertas_sc_log_runtime.log`
- `04_Anexos/EVIDENCIAS/alertas_sc_log_cron.log`

## 4) Rollback rapido (si fuera necesario)

```bash
sudo cp -a /opt/lampp/etc/httpd.conf.bak_idor_YYYYMMDD_HHMMSS /opt/lampp/etc/httpd.conf
sudo rm -f /etc/cron.d/idor_sc_log_alertas
sudo /opt/lampp/lampp reloadapache
```

Reemplazar `YYYYMMDD_HHMMSS` por el timestamp del respaldo generado por el script.
