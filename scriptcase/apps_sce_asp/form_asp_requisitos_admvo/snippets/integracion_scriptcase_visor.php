<?php
declare(strict_types=1);

/*
 * ================================================================================
 * PLANTILLA — para GRID: copiar a onRecord. Para FORMULARIO: no asignes HTML a id_asp_FK
 * (campo numérico); usa el evento onLoad con JS como en ../Eventos/onLoad.
 * Ver ../docs/VISOR_DOCUMENTOS_ADMVO.md
 *
 * {id_asp_FK} es sintaxis Scriptcase: debe coincidir con un campo del SQL del grid.
 * ================================================================================

$visor_root = '/opt/lampp/htdocs/visor-requisitos-admvo';

require_once $visor_root . '/config.php';
require_once $visor_root . '/lib/token.php';

$id_asp = (int) {id_asp_FK};
$token = generateDownloadToken($id_asp, 'adm-visor-req');
$base = rtrim(VISOR_PUBLIC_BASE_URL, '/');
$visor_url = $base . '/index.php?type=adm-visor-req&id=' . $id_asp . '&token=' . urlencode($token);

{id_asp_FK} = htmlspecialchars((string) {id_asp_FK})
    . ' <a href="' . htmlspecialchars($visor_url) . '" target="_blank" rel="noopener" '
    . 'title="Expediente del aspirante" '
    . 'style="display:inline-block;margin-left:8px;padding:4px 10px;background:#1e4d7b;color:#fff;text-decoration:none;border-radius:4px;font-size:12px;">Ver documentos</a>';

 * ================================================================================
 */
