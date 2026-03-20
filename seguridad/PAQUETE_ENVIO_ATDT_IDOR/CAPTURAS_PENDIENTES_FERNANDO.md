# Evidencia operativa minima (ScriptCase)

Objetivo: documentar solo lo necesario para ATDT, sin sobreexponer informacion sensible.

---

## Instrucciones para cada captura

<span style="color:red"><strong>OBLIGATORIO:</strong></span>

<span style="color:red">1) Debe verse la URL completa en el navegador.</span>  
<span style="color:red">2) Debe verse el rol/cuenta de prueba usada (sin exponer password).</span>  
<span style="color:red">3) Debe verse claramente el resultado (bloqueo, error o acceso esperado).</span>  
<span style="color:red">4) Debe incluirse pie de foto explicando que demuestra.</span>

### Plantilla de pie de foto (copiar/pegar)

<span style="color:red"><strong>Pie de foto:</strong> Esta evidencia corresponde al control [A2/A4/E2/F3]. Muestra [descripcion breve del evento]. El resultado observado fue [resultado], consistente con [cumple/en proceso].</span>

---

## Capturas requeridas

### E1. Bloqueo por permisos en SCE
- Usuario estudiante intenta abrir URL administrativa.
- Resultado esperado: bloqueo/redireccion.

### E2. Bloqueo por permisos en SCE_ASP
- Usuario aspirante intenta abrir URL administrativa.
- Resultado esperado: bloqueo/redireccion.

### E3. Bloqueo por permisos en SCE_ENBC
- Usuario aspirante intenta abrir URL administrativa.
- Resultado esperado: bloqueo/redireccion.

### E4. Login fallido + registro en sc_log
- Intento de login incorrecto.
- Captura de salida de query agregada/reciente de `action='login Fail'`.

### E5. HTTPS activo en los 3 sistemas
- Captura del candado y `https://` en login de SCE, SCE_ASP y SCE_ENBC.

---

## Entrega

Guardar en: `04_Anexos/Anexo_E_Pruebas_IDOR/`  
Nombres sugeridos: `E1_sce_bloqueo.png`, `E2_sce_asp_bloqueo.png`, `E3_sce_enbc_bloqueo.png`, `E4_login_fail_log.png`, `E5_https_3sistemas.png`.
