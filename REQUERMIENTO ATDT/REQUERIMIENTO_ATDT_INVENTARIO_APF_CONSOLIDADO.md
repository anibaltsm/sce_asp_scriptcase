# Requerimiento ATDT — Inventario institucional APF (consolidado en Markdown)

Documento de trabajo que reúne el **contexto del correo**, el **oficio**, la **guía de cifrado (Anexo 5)**, la **estructura del instrumento Excel** y la **referencia a la llave pública PGP**. Los PDF y el XLSX originales permanecen en esta misma carpeta.

## Archivos fuente en esta carpeta

| Archivo | Descripción |
|--------|-------------|
| `Oficio Levantamiento del Inventario.pdf` | Oficio ATDT/CNID/DGC/013/2026 |
| `Instrumento_Institucional_Inventario_APF.xlsx` | Instrumento oficial (solo este formato) |
| `Anexo 5. Guia cifrado y descifrado.pdf` | Guía PGP / Gpg4win (Windows) |
| `Agencia de Transformación Digital y Telecomunicaciones_0x62A61D25E54EA4CB_public.asc` | Llave pública PGP de la DGCiber |

**Nota de extracción:** el texto de los PDF se obtuvo con `pdftotext -layout`. Las capturas/gráficos de la guía no se reproducen aquí; conviene conservar el PDF para las ilustraciones. La hoja principal del Excel es muy extensa; abajo se documentan **nombres de hojas**, **instructivo**, **catálogos**, **ponderación** y el **listado de columnas** del inventario (primera fila exportada vía LibreOffice a CSV).

---

## 1. Texto del correo (seguimiento / coordinación)

> Estimadas y estimados UTICs y RICs:
>
> En seguimiento a las acciones de fortalecimiento de la gestión de riesgos tecnológicos en la APF, se remite el **Oficio Núm. ATDT/CNID/DGC/013/2026** mediante el cual se instruye el levantamiento del **Inventario Institucional de Sistemas, Versiones e Infraestructura Tecnológica**.
>
> Se adjunta el instrumento oficial **Instrumento_Institucional_Inventario_APF.xlsx**, el cual deberá:
>
> - Ser **requisitado en su totalidad**.
> - **Validarse internamente** con las áreas responsables.
> - **Cifrarse** con la **llave pública PGP de la DGCiber**.
> - **Firmarse digitalmente** con la **llave privada PGP del RIC**.
>
> Les solicitamos **coordinar internamente** el levantamiento técnico de la información y **prever tiempos de validación**.
>
> Para **dudas técnicas** relacionadas con el llenado o el cifrado PGP, favor de **contactar a esta Dirección General**.
>
> Agradecemos su compromiso y colaboración para fortalecer conjuntamente la gestión de riesgos y la resiliencia digital de la Administración Pública Federal.
>
> --  
> **Dirección General de Ciberseguridad**  
> **COORDINACIÓN NACIONAL DE INFRAESTRUCTURA DIGITAL**  
> **AGENCIA DE TRANSFORMACIÓN DIGITAL Y TELECOMUNICACIONES**

---

## 2. Oficio — puntos clave (resumen)

- **Número:** ATDT/CNID/DGC/013/2026  
- **Fecha (documento):** Ciudad de México, 27 de febrero de 2026  
- **Destinatarios:** UTICs y RICs de dependencias, OADs y entidades de la APF  
- **Fundamento (citado):** LOAPF; RI de la ATDT (art. 19, fracc. VII y X, DGCiber); Política General de Ciberseguridad para la APF  
- **Finalidad:** Línea base verificable de activos tecnológicos; identificación, documentación y clasificación por criticidad, exposición y soporte; insumo para gestión de riesgos y priorización de ciberseguridad  
- **Alineación:** Eje Estratégico 2 — OE2.1 (inventarios de activos por criticidad)  
- **Instrumento:** Únicamente `Instrumento_Institucional_Inventario_APF.xlsx` — no otros formatos ni cambios estructurales  
- **Envío:** Cifrar con **llave pública PGP DGCiber**; firmar con **llave privada PGP del RIC**; adjunta guía “Anexo 5…”; la DGCiber envía su llave pública; el **RIC debe compartir su llave pública** para verificación  
- **Plazo:** **30 días naturales** desde la notificación del oficio  
- **Confidencialidad:** Uso exclusivo para gestión de riesgos, análisis técnico y ciberseguridad institucional  
- **Firma:** Heidy Karla Rocha Ruiz — Directora General de Ciberseguridad  

**Beneficios mencionados en el oficio:** detección temprana de riesgos y sistemas fuera de soporte; reportes focalizados de CVEs (KEV, CVSS); análisis sobre sistemas expuestos; mejor priorización de remediaciones y resiliencia operativa.

---

## 3. Oficio — texto extraído del PDF

Ciudad de México, a 27 de febrero de 2026  

**Oficio Núm. ATDT/CNID/DGC/013/2026**  

**ASUNTO:** Levantamiento del Inventario Institucional de Sistemas, Versiones e Infraestructura Tecnológica  

A las y los UTICs y RICs de las Dependencias, Órganos Administrativos Desconcentrados y Entidades de la Administración Pública Federal  

En el ámbito de sus respectivas competencias:

Con fundamento en la Ley Orgánica de la Administración Pública Federal; en el Reglamento Interior de la Agencia de Transformación Digital y Telecomunicaciones, particularmente en su artículo 19, fracciones VII y X, que confieren atribuciones en materia de ciberseguridad a la Dirección General de Ciberseguridad de la Agencia de Transformación Digital y Telecomunicaciones (en lo sucesivo, DGCiber); así como en la Política General de Ciberseguridad para la Administración Pública Federal; se emite el presente Oficio, mediante el cual se instruye el levantamiento y remisión del Inventario Institucional en los términos señalados.

El levantamiento del Inventario Institucional de Sistemas, Versiones e Infraestructura Tecnológica tiene como finalidad establecer una línea base institucional verificable de los activos tecnológicos que soportan las funciones sustantivas y administrativas de las dependencias y entidades de la APF, permitiendo su identificación, documentación y clasificación por criticidad, exposición y nivel de soporte, como insumo indispensable para la gestión dinámica de riesgos y la priorización de acciones de ciberseguridad.

Lo anterior se vincula directamente con el Eje Estratégico 2 (Gestión de riesgos y resiliencia operativa), particularmente con el OE2.1 relativo a la elaboración y mantenimiento de inventarios de activos clasificados por criticidad.

Los beneficios de este ejercicio permitirán:

- Identificar riesgos de forma temprana, detectando sistemas fuera de soporte o con exposición innecesaria.  
- Recibir reportes focalizados de vulnerabilidades (CVEs) dedicados por tecnología realmente utilizada, mediante cruce con listados KEV y priorización basada en CVSS.  
- Realizar análisis técnicos de vulnerabilidades sobre sistemas expuestos a Internet con criterios de severidad CVSS y criticidad institucional.  
- Optimizar la priorización de remediaciones y fortalecer la resiliencia operativa.  

Para tal efecto:

El inventario deberá ser requisitado exclusivamente en el archivo Excel oficial adjunto denominado “Instrumento_Institucional_Inventario_APF.xlsx”. No se aceptarán formatos distintos ni modificaciones estructurales.

Una vez debidamente llenado y validado, el archivo deberá cifrarse utilizando la llave pública PGP de la DGCiber y firmarse digitalmente con la llave privada PGP del Responsable Institucional de Ciberseguridad (RIC) antes de su envío. Se adjunta también el documento denominado “Anexo 5. Guia cifrado y descifrado.pdf” para mayor referencia.

La DGCiber proporciona en archivo zip adjunto su llave pública PGP. El RIC deberá compartir su llave pública PGP para efectos de verificación.

El inventario deberá remitirse en un plazo máximo de 30 días naturales contados a partir de la notificación del presente Oficio.

La información contenida en el instrumento tendrá carácter confidencial y será utilizada exclusivamente para fines de gestión de riesgos, análisis técnico y fortalecimiento de la ciberseguridad institucional, en términos de la normatividad aplicable.

Sin otro particular, agradecemos la atención prestada al presente Oficio y la colaboración institucional para su puntual cumplimiento, en el marco del fortalecimiento de la gestión de riesgos y la resiliencia digital de la Administración Pública Federal.

Atentamente  

**Heidy Karla Rocha Ruiz**  
Directora General de Ciberseguridad  

---

## 4. Instrumento Excel — hojas y contenido auxiliar

### 4.1 Hojas del libro

1. **Inventario_Sistemas** — Registro principal (campos en listado de la sección 4.3).  
2. **Instructivo** — Notas de llenado.  
3. **Resumen_Ejecutivo** — Indicadores que se alimentan del inventario (uso para titulares/comités).  
4. **Catálogos** — Valores válidos de referencia (clasificaciones, tipos, tecnologías, etc.).  
5. **Ponderación** — Pesos de factores para el score automático.  

### 4.2 Texto de la hoja *Instructivo* (extraído)

- **INSTRUCTIVO DE LLENADO – Inventario Institucional de Sistemas, Versiones e Infraestructura Tecnológica**  
- **Proveedor nube:** Seleccione el proveedor donde reside la infraestructura principal del sistema. Use N/A si es On-prem.  
- **Frecuencia de respaldos:** Indique periodicidad real (Diario/Semanal/Mensual/Trimestral/Bajo Demanda/N/A).  
- **Ejemplo – Listado de componentes open source (Nombre – Versión):**  
  - Spring Boot – 2.5.4  
  - Log4j – 2.14.1  
  - OpenSSL – 1.1.1  
- **Nota:** Capture siempre versiones. Si desconoce, registre `Por confirmar` y programe validación técnica.  

### 4.3 Hoja *Resumen_Ejecutivo* (mensajes relevantes)

- Este resumen se alimenta automáticamente del inventario. Útil para titulares y comités.  
- Incluye totales por nivel de riesgo, porcentajes, promedio de score total y recomendaciones de priorización.  
- **Recomendación:** Ordenar la hoja `Inventario_Sistemas` por `Score total` descendente para priorizar remediación (Crítico/Alto). Adicionalmente filtrar por `¿Componentes EOL?` = Sí y `¿Expuesto a Internet?` = Sí.  
- Bloque de priorización por dependencia (Crítico+Alto) con columnas: Dependencia / Entidad, Crítico+Alto (Auto), Total sistemas.  

### 4.4 Hoja *Ponderación*

| Factor | Peso |
|--------|------|
| Exposición pública | 0.3 |
| Componentes EOL/Soporte | 0.25 |
| Sin MFA | 0.15 |
| Sin respaldo | 0.15 |
| Vuln críticas | 0.15 |

### 4.5 Hoja *Catálogos* (cabecera y uso)

La primera fila define columnas de catálogo, entre ellas: **Sí/No**, **Clasificación**, **TipoSistema**, **Ambiente**, **Lenguaje**, **Framework**, **BD**, **SO**, **WebServer**, **AuthTipo**, **InfraTipo**, **NubeProveedor**, **FreqBackup**, **Declaratoria**. Las filas siguientes listan valores ejemplo (Crítico/Alto/…, Web/Legado/…, AWS/Azure/…, etc.). El detalle completo está en el XLSX.

### 4.6 Columnas de la hoja *Inventario_Sistemas* (fila de encabezados)

1. ID Sistema  
2. Nombre oficial del sistema  
3. Acrónimo  
4. Dependencia / Entidad  
5. Unidad responsable (Dueño del sistema)  
6. Función institucional que soporta  
7. Clasificación del sistema (Crítico/Alto/Medio/Bajo)  
8. Tipo de sistema (Web/Legado/BD/API/Móvil/Otro)  
9. Ambiente principal (Prod/Preprod/Dev/Otro)  
10. Versión actual del sistema  
11. Fecha de última actualización (release productivo)  
12. Lenguaje principal  
13. Framework  
14. Base de datos  
15. Versión de Base de Datos  
16. Sistema Operativo del servidor  
17. Versión del SO  
18. Web server / App server  
19. ¿Usa componentes open source?  
20. Listado de componentes open source (si aplica)  
21. ¿Tiene componentes EOL (End of Life)?  
22. Fecha fin de soporte fabricante  
23. Score riesgo tecnológico (EOL/Soporte)  
24. URL pública (si aplica)  
25. IP pública (si aplica)  
26. ¿Tiene WAF?  
27. ¿Está detrás de CDN?  
28. ¿Requiere autenticación?  
29. Tipo de autenticación (MFA/AD/OAuth/Otro)  
30. ¿Cuenta con certificado SSL válido?  
31. Fecha expiración SSL  
32. ¿Tiene DNSSEC?  
33. ¿SPF/DKIM/DMARC configurado?  
34. ¿Expuesto a Internet?  
35. Puertos abiertos (si aplica)  
36. ¿Escaneo reciente de vulnerabilidades?  
37. Fecha último escaneo  
38. Vulnerabilidades críticas abiertas (número)  
39. Score exposición  
40. Tipo de infraestructura (On-prem/Nube pública/Híbrido)  
41. Proveedor nube (AWS/Azure/GCP/Nacional/N/A)  
42. ¿Infraestructura compartida?  
43. ¿Segmentación de red?  
44. ¿Microsegmentación?  
45. ¿Reside en infraestructura crítica?  
46. ¿Tiene respaldo automatizado?  
47. Frecuencia de respaldos (Diario/Semanal/Mensual)  
48. RTO (horas)  
49. RPO (horas)  
50. ¿Replica en sitio alterno?  
51. Score respaldo  
52. ¿Integrado a AD institucional?  
53. ¿Tiene MFA habilitado?  
54. ¿Control de accesos basado en roles (RBAC)?  
55. ¿Cuenta con PAM?  
56. Número de usuarios activos  
57. Número de cuentas privilegiadas  
58. ¿Revisión periódica de accesos?  
59. Última revisión de accesos (AAAA-MM-DD)  
60. Score identidad/accesos (MFA)  
61. ¿EDR instalado en servidor?  
62. ¿Logs enviados a SIEM?  
63. ¿Monitoreado por SOC?  
64. ¿Pruebas de penetración realizadas?  
65. Fecha último pentest  
66. ¿Hardening aplicado?  
67. Baseline aplicado  
68. ¿Plan de continuidad documentado?  
69. Score vulnerabilidades  
70. Score total automático (ponderado)  
71. Nivel de riesgo (Crítico/Alto/Medio/Bajo)  
72. Declaratoria de veracidad (Sí/No)  

---

## 5. Anexo 5 — Guía de cifrado y descifrado (texto extraído del PDF)

**Anexo 5 — Guía para el cifrado y descifrado de información utilizando llaves públicas y privadas**

### Objetivo

Mostrar cómo mantener la confidencialidad, integridad y autenticidad en comunicaciones por correo mediante cifrado y clave pública, para enviar correos y archivos de forma segura. Referencia: “Guía para el uso de PGP en clientes de correo electrónico” (INCIBE, España). Se usa **PGP/OpenPGP** y la guía enseña el uso básico de **Gpg4win** en **Windows**.

### Introducción

Aunque exista SSL/TLS (p. ej. HTTPS), el correo puede seguir siendo vulnerable; se recomienda **GPG** para comunicación segura, mitigando MITM, sniffers y filtraciones por contraseñas. GPG permite **firma digital** (RSA, DSA). Longitud de llave configurable (1536–4096 bits); **4096 bits recomendable**.

### Programas (Gpg4win)

- **Kleopatra:** gestor de certificados PGP (crear, modificar, exportar, etc.).  
- **GpgOL:** complemento de Outlook para cifrar, descifrar, firmar y verificar correos y adjuntos.  

Descarga: https://www.gpg4win.org/

### Creación de llave pública y privada (Kleopatra)

1. Ejecutar Kleopatra.  
2. Archivo → Nuevo par de claves…  
3. Crear un par de claves personales OpenPGP.  
4. Nombre, correo; Configuración avanzada.  
5. Algoritmo **RSA**, **4096 bits** → Creación de llaves (demás opciones por defecto).  
6. Contraseña robusta: mínimo **12 caracteres**, mayúsculas, minúsculas y especiales.  
7. Confirmación: “Par de claves creado con exito”.  

### Compartir e importar llave pública

- Exportar: clic derecho en certificado → Exportar → archivo `.asc`; adjuntar al correo.  
- Importar: arrastrar llave al programa → Importar Certificado → Ok.  

### Cifrar y descifrar archivos (Kleopatra)

Arrastrar el archivo a Kleopatra.

**Cifrado:** Firmar/Cifrar; elegir clave con la que se firma y destinatario (llave pública del destino). Resultado: archivo `.gpg`.  

**Descifrado:** Descifrar/Verificar; contraseña y llave privada del destinatario.  

**Firma (archivo):** Arrastrar archivo; opción de cifrar y firmar; en el ejemplo de la guía se desmarcan “cifrar para mí” y “cifrar para otros” dejando solo firma; introducir contraseña; se genera archivo de firma.  

### Glosario (resumen)

- **GPG / GNU Privacy Guard:** similar a PGP, software libre (GPL), estándar OpenPGP.  
- **PGP:** cifrado con llave pública y firma digital.  
- **Sniffer:** captura de tráfico en red.  
- **RSA:** asimétrico, cifrado por bloques.  
- **DSA:** solo firma, no cifrado.  

### Referencias (como en el PDF)

1. Gpg4win — https://www.gpg4win.org/  
2. INCIBE — guía PGP en clientes de correo (URL partida en el PDF original; ver el PDF para el enlace completo).  

---

## 6. Llave pública PGP de la DGCiber (referencia)

- **Archivo:** `Agencia de Transformación Digital y Telecomunicaciones_0x62A61D25E54EA4CB_public.asc`  
- **UID (según `gpg --import-options show-only`):** Agencia de Transformación Digital y Telecomunicaciones \<servicios.ciber@transformaciondigital.gob.mx\>  
- **Huella (fingerprint):** `8956 9135 9CAF D058 12EA 071F 62A6 1D25 E54E A4CB`  
- **Tipo / vigencia (según la misma salida):** RSA 4096, creada 2026-02-11, caduca 2027-02-11  

Para operación real de cifrado/verificación, usar siempre el archivo `.asc` oficial y confirmar la huella por un canal de confianza institucional.

---

*Generado para facilitar búsqueda y versionado en texto plano; no sustituye los documentos oficiales en PDF/XLSX.*
