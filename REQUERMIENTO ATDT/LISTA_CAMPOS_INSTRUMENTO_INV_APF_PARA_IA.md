# Lista de llenado — `Instrumento_Institucional_Inventario_APF.xlsx` (para usar con otra IA)

## Alcance: solo estos tres sistemas

En el Excel debes inventariar **únicamente tres filas** en **`Inventario_Sistemas`**, una por sistema:

| # | Identificador / nombre de trabajo | Nota |
|---|-----------------------------------|------|
| 1 | **SCE** | Sistema SCE |
| 2 | **SCE_ASP** | Sistema SCE_ASP (p. ej. capa ASP asociada al ecosistema SCE) |
| 3 | **SCE_ENBC** | Sistema SCE_ENBC |

El resto del libro (resumen, catálogos, ponderación) sigue igual; **no** añadas filas para otros sistemas salvo que tu entidad te lo ordene por separado.

**Tabla de las 3 filas + plan de revisión** (mapeo campo ↔ documentación del repo): ver `TABLA_Y_PLAN_REVISION_DOCS_3_SISTEMAS.md`.

---

## Qué debes llenar tú (resumen)

| Hoja | ¿La lleno a mano? |
|------|-------------------|
| **Inventario_Sistemas** | **Sí.** Exactamente **3 filas**: **SCE**, **SCE_ASP** y **SCE_ENBC** (mismos 72 campos por fila). |
| **Instructivo** | No (solo lectura). |
| **Resumen_Ejecutivo** | Normalmente **no** (se alimenta del inventario). |
| **Catálogos** | **Consulta** para valores permitidos (Sí/No, tipos, etc.). No inventes valores si el Excel valida listas. |
| **Ponderación** | No tocar (pesos del modelo). |

**Reglas del oficio:** solo ese archivo Excel, **sin cambiar estructura** (no agregar/quitar columnas ni mover el formato). Si un dato no se conoce, el instructivo sugiere poner **`Por confirmar`** y acordar validación técnica (sobre todo en **versiones** y componentes open source: siempre **Nombre – Versión**).

**Valores de catálogo útiles (hoja *Instructivo*):** frecuencia de respaldos puede ser **Diario / Semanal / Mensual / Trimestral / Bajo Demanda / N/A**. Proveedor nube: si es on-prem, **N/A**.

---

## Plantilla de prompt para otra IA (copiar y adaptar)

```
Contexto: Debo llenar el inventario ATDT "Instrumento_Institucional_Inventario_APF.xlsx" (hoja Inventario_Sistemas).
Alcance estricto: SOLO tres sistemas, cada uno en su propia fila: (1) SCE, (2) SCE_ASP, (3) SCE_ENBC.
Para CADA uno de esos tres sistemas, ayúdame a completar TODOS los campos de la lista numerada que te paso abajo.
Entrega la salida en tres bloques claros: === SCE ===, === SCE_ASP ===, === SCE_ENBC ===.
Para cada campo indica: (1) qué significa, (2) dónde suele estar esa información (equipo/rol), (3) valor propuesto o "Por confirmar" / N/A.
No modifiques la estructura del Excel; respeta Sí/No y listas del catálogo si existen.

[Lista de campos — pegar la sección "Lista numerada" de este mismo documento]
```

---

## Lista numerada: campo → qué buscar / con quién validar

Usa **una fila del Excel por sistema** → en tu caso **3 filas** (SCE, SCE_ASP, SCE_ENBC). Los campos con nombre **Score** suelen ser **calculados por el libro** (fórmulas); si ya vienen con fórmula, **no los sobrescribas**. Si están vacíos y no hay fórmula, pregunta a TI o revisa el instructivo del propio Excel.

1. **ID Sistema** — Identificador interno o correlativo institucional del activo.  
2. **Nombre oficial del sistema** — Nombre legal o de registro del sistema (contratos, CMDB, oficios).  
3. **Acrónimo** — Siglas conocidas en la entidad.  
4. **Dependencia / Entidad** — Nombre oficial de la dependencia u organismo.  
5. **Unidad responsable (Dueño del sistema)** — Área dueña del negocio o responsable del sistema.  
6. **Función institucional que soporta** — Qué proceso misional o administrativo cubre (matriz de aplicaciones, manual de organización).  
7. **Clasificación del sistema (Crítico/Alto/Medio/Bajo)** — Criterio institucional de criticidad (BIA, continuidad, matriz de riesgos).  
8. **Tipo de sistema (Web/Legado/BD/API/Móvil/Otro)** — Arquitectura principal de entrega.  
9. **Ambiente principal (Prod/Preprod/Dev/Otro)** — Dónde opera el uso real principal.  
10. **Versión actual del sistema** — Versión en producción (release, tag, build).  
11. **Fecha de última actualización (release productivo)** — Fecha del último despliegue relevante.  
12. **Lenguaje principal** — Lenguaje de la app backend/ principal (equipo de desarrollo).  
13. **Framework** — Spring, .NET, Laravel, etc.  
14. **Base de datos** — Motor (Oracle, SQL Server, PostgreSQL…).  
15. **Versión de Base de Datos** — Versión exacta del motor.  
16. **Sistema Operativo del servidor** — SO de hosts donde corre (Linux, Windows Server…).  
17. **Versión del SO** — Versión/patch level si aplica.  
18. **Web server / App server** — IIS, Apache, Nginx, Tomcat, WebLogic, etc.  
19. **¿Usa componentes open source?** — Sí/No (stack, SBOM, repositorio).  
20. **Listado de componentes open source (si aplica)** — Formato **Nombre – Versión** (ej. Log4j – 2.14.1). Si no se sabe: **Por confirmar**.  
21. **¿Tiene componentes EOL (End of Life)?** — Sí/No (vs. fechas de soporte del fabricante o del proyecto).  
22. **Fecha fin de soporte fabricante** — Fecha EOL conocida del producto/SO/BD clave.  
23. **Score riesgo tecnológico (EOL/Soporte)** — Suele ser **automático** en el Excel.  
24. **URL pública (si aplica)** — FQDN o URL accesible desde Internet; vacío si no hay.  
25. **IP pública (si aplica)** — IP expuesta; vacío si no hay.  
26. **¿Tiene WAF?** — Sí/No (seguridad perimetral / arquitectura).  
27. **¿Está detrás de CDN?** — Sí/No (Cloudflare, Akamai, etc.).  
28. **¿Requiere autenticación?** — Sí/No.  
29. **Tipo de autenticación (MFA/AD/OAuth/Otro)** — Mecanismo real de acceso.  
30. **¿Cuenta con certificado SSL válido?** — Sí/No (HTTPS).  
31. **Fecha expiración SSL** — Caducidad del certificado si aplica.  
32. **¿Tiene DNSSEC?** — Sí/No (DNS).  
33. **¿SPF/DKIM/DMARC configurado?** — Sí/No (correo del dominio relacionado, si aplica al sistema).  
34. **¿Expuesto a Internet?** — Sí/No (alcance de red).  
35. **Puertos abiertos (si aplica)** — Listado relevante si está expuesto (ej. 443, 22…).  
36. **¿Escaneo reciente de vulnerabilidades?** — Sí/No (VA program).  
37. **Fecha último escaneo** — Fecha del último escaneo autorizado.  
38. **Vulnerabilidades críticas abiertas (número)** — Conteo según herramienta/gestión de vulnerabilidades.  
39. **Score exposición** — Suele ser **automático**.  
40. **Tipo de infraestructura (On-prem/Nube pública/Híbrido)** — Modelo de despliegue.  
41. **Proveedor nube (AWS/Azure/GCP/Nacional/N/A)** — Si on-prem: **N/A** (según instructivo).  
42. **¿Infraestructura compartida?** — Sí/No (multitenant, cluster compartido).  
43. **¿Segmentación de red?** — Sí/No (VLANs, zonas).  
44. **¿Microsegmentación?** — Sí/No.  
45. **¿Reside en infraestructura crítica?** — Sí/No (según definición institucional).  
46. **¿Tiene respaldo automatizado?** — Sí/No (backup programado).  
47. **Frecuencia de respaldos (Diario/Semanal/Mensual)** — Periodicidad **real**; el instructivo también admite Trimestral / Bajo Demanda / N/A en la guía de la hoja Instructivo.  
48. **RTO (horas)** — Objetivo de tiempo de recuperación acordado/documentado.  
49. **RPO (horas)** — Objetivo de pérdida de datos aceptable en horas.  
50. **¿Replica en sitio alterno?** — Sí/No (DR).  
51. **Score respaldo** — Suele ser **automático**.  
52. **¿Integrado a AD institucional?** — Sí/No (Active Directory / directorio).  
53. **¿Tiene MFA habilitado?** — Sí/No (acceso administrativo o de usuarios, según aplique al sistema).  
54. **¿Control de accesos basado en roles (RBAC)?** — Sí/No.  
55. **¿Cuenta con PAM?** — Sí/No (gestión de privilegios).  
56. **Número de usuarios activos** — Aproximado o de IAM/analytics (definir criterio institucional).  
57. **Número de cuentas privilegiadas** — Cuentas admin/root/db_owner, etc.  
58. **¿Revisión periódica de accesos?** — Sí/No (proceso de recertificación).  
59. **Última revisión de accesos (AAAA-MM-DD)** — Fecha de la última revisión documentada.  
60. **Score identidad/accesos (MFA)** — Suele ser **automático**.  
61. **¿EDR instalado en servidor?** — Sí/No (endpoint detection en servidores).  
62. **¿Logs enviados a SIEM?** — Sí/No.  
63. **¿Monitoreado por SOC?** — Sí/No.  
64. **¿Pruebas de penetración realizadas?** — Sí/No.  
65. **Fecha último pentest** — Fecha del último ejercicio autorizado.  
66. **¿Hardening aplicado?** — Sí/No (bastionado CIS/benchmark).  
67. **Baseline aplicado** — Cuál baseline o estándar (nombre o versión).  
68. **¿Plan de continuidad documentado?** — Sí/No (BCP/DRP para el sistema).  
69. **Score vulnerabilidades** — Suele ser **automático**.  
70. **Score total automático (ponderado)** — Suele ser **automático**.  
71. **Nivel de riesgo (Crítico/Alto/Medio/Bajo)** — Suele ser **automático** a partir de scores.  
72. **Declaratoria de veracidad (Sí/No)** — Conforme a catálogo (ej. declaración bajo protesta); validar con RIC/legal interno.

---

## Checklist rápido por “dueños” de información (para coordinar)

Ámbito: repetir el mismo esquema de coordinación **por cada uno** de **SCE**, **SCE_ASP** y **SCE_ENBC** (tres pasadas o una mesa de trabajo conjunta).

- **Negocio / área usuaria:** 5, 6, 7 (criterio), 56 (usuarios, criterio).  
- **Desarrollo / mantenimiento:** 10–18, 19–22.  
- **Infra / cloud / CPD:** 40–47, 50, 42–45.  
- **Red / seguridad perimetral:** 24–27, 34–35, 30–33.  
- **Ciberseguridad / SOC:** 36–38, 61–63, 64–66, 67–68.  
- **Identidad / directorio:** 28–29, 52–55, 58–59.  
- **RIC / gobierno:** 7, 72, validación final de filas.

---

## Recordatorio de entrega (no es llenado del Excel, pero es parte del requerimiento)

- Llenar **todo** el instrumento, validar con áreas.  
- **Cifrar** con llave pública PGP DGCiber.  
- **Firmar** con llave privada PGP del RIC.  
- RIC comparte su **llave pública** para verificación.

---

*Archivo auxiliar para búsqueda y prompts; el criterio oficial sigue siendo el Excel y el oficio ATDT.*
