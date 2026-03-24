# Acta de gobernanza de superficie expuesta
## Cierre documental C2 / F2 (IDOR - ATDT)

**Institucion:** INECOL  
**Area:** Secretaria de Posgrado  
**Fecha:** 24-mar-2026  
**Alcance:** SCE, SCE_ASP, SCE_ENBC

---

## 1) Determinacion de superficie operativa vigente

Se valida como superficie activa y justificada:

- `https://posgrados.inecol.mx/sce/`
- `https://posgrados.inecol.mx/sce_asp/`
- `https://posgrados.inecol.mx/sce_enbc/`

No se identifican versiones publicas paralelas (`v1`, `v2`) con controles de autorizacion diferenciados para este alcance.

## 2) Servicios heredados y respaldos

Se confirma retiro/aislamiento de artefactos historicos de respaldo fuera de `htdocs` y/o bloqueo de acceso web:

- Evidencia de configuracion de bloqueo: `C1_A_*_htaccess.png`
- Evidencia de resguardo fuera de webroot: `C1_B_Respaldos_Fuera_htdocs.png`
- Evidencia externa de no exposicion: `C1_C_*_404o403_VerificacionExterna.png`

## 3) Criterio formal de gobernanza aplicado

1. Cualquier componente no requerido para operacion publica se clasifica como no operativo.
2. Si conserva valor historico, se mueve a ruta de resguardo fuera de webroot.
3. Si por contingencia debe coexistir temporalmente en servidor, queda con bloqueo explicito de acceso.
4. Todo cambio de superficie se refleja en anexos C/H del paquete ATDT.

## 4) Estado de cierre C2/F2

- **C2 (versiones/servicios heredados):** Cumple documentalmente, con inventario y criterio de gobernanza.
- **F2 (retiro/aislamiento):** Cumple tecnicamente, con evidencia A/B/C por sistema.

## 5) Referencias de trazabilidad

- Informe maestro: `INFORME_MAESTRO_ATDT_IDOR_PARA_WORD.md`
- Anexo C (inventario y no exposicion): tablas C.1 y C.1.D
- Anexo H (seguimiento de cierre): acciones y evidencia esperada
