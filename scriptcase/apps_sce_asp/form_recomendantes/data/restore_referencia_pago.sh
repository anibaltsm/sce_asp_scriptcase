#!/usr/bin/env bash
# -----------------------------------------------------------------------------
# Restaurar referencia de pago en sce.pagos para un id_asp dado.
# Obtiene nombre y login de sce_asp.aspirantes, generación de sce.convocatorias_posg,
# genera la referencia (INECOLPA0002...) e inserta si no existe.
# Uso: ./restore_referencia_pago.sh <id_asp>
# Ejemplo: ./restore_referencia_pago.sh 1301
# -----------------------------------------------------------------------------

set -e

# Configuración MySQL (ajustar a tu entorno)
MYSQL_CMD="${MYSQL_CMD:-/opt/lampp/bin/mysql}"
MYSQL_USER="${MYSQL_USER:-root}"
MYSQL_PASS="${MYSQL_PASS:-515t3ma5}"
MYSQL_OPTS="-u $MYSQL_USER -p$MYSQL_PASS"

id_asp="${1:-}"
if [ -z "$id_asp" ]; then
    echo "Uso: $0 <id_asp>"
    echo "Ejemplo: $0 1301"
    exit 1
fi

# id_asp sin ceros a la izquierda
id_asp_limpio=$(echo "$id_asp" | sed 's/^0*//')
[ -z "$id_asp_limpio" ] && id_asp_limpio=0

# Obtener nombre completo y login del aspirante (sce_asp); una sola línea, tab como separador
line="$($MYSQL_CMD $MYSQL_OPTS sce_asp -N -e "
    SELECT IFNULL(login_FK,''), TRIM(CONCAT(IFNULL(nombres,''),' ',IFNULL(ap_pat,''),' ',IFNULL(ap_mat,'')))
    FROM aspirantes WHERE id_asp = $id_asp_limpio LIMIT 1;
" 2>/dev/null | head -1 | tr -d '\n\r')"
login="${line%%$'\t'*}"
nombre="${line#*$'\t'}"

if [ -z "$nombre" ] && [ -z "$login" ]; then
    echo "ERROR: No se encontró aspirante con id_asp=$id_asp_limpio en sce_asp.aspirantes"
    exit 2
fi

# Generación activa (sce)
generacion="$($MYSQL_CMD $MYSQL_OPTS sce -N -e "
    SELECT generacion FROM convocatorias_posg
    WHERE cc_activa=1 AND (id_prog_FK<>9 OR id_prog_FK IS NULL) LIMIT 1;
" 2>/dev/null | head -1)"
[ -z "$generacion" ] && generacion="2026"

# Generar referencia (misma lógica que add_asp_aspirantes)
dato=${#id_asp_limpio}
if [ "$dato" -le 3 ]; then
    case "$dato" in
        1) ceros='000' ;;
        2) ceros='00'  ;;
        3) ceros='0'   ;;
        *) ceros=''    ;;
    esac
    referencia="INECOLPA0002${ceros}${id_asp_limpio}00"
else
    referencia="INECOLPA0002${id_asp_limpio}00"
fi

# Escapar comillas simples para SQL
nombre_esc="${nombre//\'/\'\'}"
login_esc="${login//\'/\'\'}"

echo "id_asp:    $id_asp_limpio"
echo "nombre:    $nombre"
echo "login:     $login"
echo "referencia: $referencia"
echo "generacion: $generacion"

# Comprobar si ya existe pago
existe="$($MYSQL_CMD $MYSQL_OPTS sce -N -e "
    SELECT 1 FROM pagos WHERE id_asp_FK = $id_asp_limpio AND group_id_FK = '5' LIMIT 1;
" 2>/dev/null)"
if [ -n "$existe" ]; then
    echo "Ya existe un pago para id_asp=$id_asp_limpio (group_id 5). No se inserta nada."
    exit 0
fi

# Insertar en sce.pagos
$MYSQL_CMD $MYSQL_OPTS sce -e "
INSERT INTO pagos (
    group_id_FK,
    id_asp_FK,
    nombre_interesado,
    concepto,
    monto,
    referencia,
    doc_csf,
    fecha_pago,
    login_insert,
    fecha_alta,
    ip_alta
) VALUES (
    '5',
    $id_asp_limpio,
    '$nombre_esc',
    'Derecho al proceso de seleccion $generacion',
    1250,
    '$referencia',
    NULL,
    NULL,
    '$login_esc',
    NOW(),
    '127.0.0.1'
);
" 2>/dev/null

echo "OK: Referencia de pago creada en sce.pagos (referencia=$referencia)"
exit 0
