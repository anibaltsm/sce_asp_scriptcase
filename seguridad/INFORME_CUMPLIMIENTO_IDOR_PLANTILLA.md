# Informe de cumplimiento IDOR / BOLA
## OWASP A01: Broken Access Control — Respuesta institucional

**Institución:** Instituto de Ecología, A.C. (INECOL)
**Responsable:** Secretaría de Posgrado
**Responsable Institucional de Ciberseguridad:** [NOMBRE]
**Sistemas evaluados:** SCE, SCE_ASP, SCE_ENBC
**Fecha de elaboración:** [FECHA]
**En respuesta a:** Oficio ATDT – Dirección General de Ciberseguridad, febrero 2026
**Plazo de cumplimiento:** 30 días hábiles a partir de notificación

---

# PARTE I — Tabla de los 12 requerimientos institucionales

## 1.1 Resumen de cumplimiento

| # | Requerimiento institucional | OWASP | SCE | SCE_ASP | SCE_ENBC | Evidencia entregada |
|---|----------------------------|-------|-----|---------|----------|---------------------|
| 1 | Revisar y corregir mecanismos de control de acceso a nivel de objeto | A01 | [ESTADO] | [ESTADO] | [ESTADO] | [REF SECCIÓN / ANEXO] |
| 2 | Priorizar revisión de servicios expuestos a Internet, con datos personales, accesos administrativos y servicios heredados | A01 | [ESTADO] | [ESTADO] | [ESTADO] | [REF SECCIÓN / ANEXO] |
| 3 | Garantizar que cada solicitud valide explícitamente la autorización del usuario sobre el recurso solicitado | A01 | [ESTADO] | [ESTADO] | [ESTADO] | [REF SECCIÓN / ANEXO] |
| 4 | Implementar validaciones de autorización independientes de la autenticación, aplicadas en el backend | A01 | [ESTADO] | [ESTADO] | [ESTADO] | [REF SECCIÓN / ANEXO] |
| 5 | Aplicar controles de autorización uniformes y consistentes en todos los endpoints, métodos HTTP y versiones | A01 | [ESTADO] | [ESTADO] | [ESTADO] | [REF SECCIÓN / ANEXO] |
| 6 | Ejecutar pruebas de acceso no autorizado mediante manipulación de identificadores y verificar denegación (401/403) | A01 | [ESTADO] | [ESTADO] | [ESTADO] | [REF SECCIÓN / ANEXO] |
| 7 | Evitar la exposición de referencias directas a objetos sin validación de autorización | A01 | [ESTADO] | [ESTADO] | [ESTADO] | [REF SECCIÓN / ANEXO] |
| 8 | Implementar controles de autorización centralizados y reutilizables | A01 | [ESTADO] | [ESTADO] | [ESTADO] | [REF SECCIÓN / ANEXO] |
| 9 | Retirar, deshabilitar o aislar servicios que no requieran exposición pública | A01 | [ESTADO] | [ESTADO] | [ESTADO] | [REF SECCIÓN / ANEXO] |
| 10 | Aplicar controles de autorización en operaciones de consulta, modificación, descarga y eliminación | A01 | [ESTADO] | [ESTADO] | [ESTADO] | [REF SECCIÓN / ANEXO] |
| 11 | Monitorear accesos anómalos y patrones de enumeración de objetos | A01 | [ESTADO] | [ESTADO] | [ESTADO] | [REF SECCIÓN / ANEXO] |
| 12 | Gestionar la rotación o restablecimiento de credenciales, tokens o llaves asociadas | A01 | [ESTADO] | [ESTADO] | [ESTADO] | [REF SECCIÓN / ANEXO] |

> **Estados posibles:** ✅ Cumple · ⚠️ En proceso (indicar plan y plazo) · ❌ No cumple (indicar plan y plazo)

## 1.2 Evidencia esperada por requerimiento (según oficio ATDT)

| # | Evidencia que solicita la ATDT |
|---|-------------------------------|
| 1 | Documento de análisis de controles de acceso por sistema; diagrama o descripción de autorización a nivel de objeto |
| 2 | Inventario de sistemas evaluados; listado de URLs públicas; clasificación de criticidad |
| 3 | Evidencia de validación de pertenencia (ownership check); fragmentos de lógica de autorización o pseudocódigo |
| 4 | Descripción del modelo de autorización (roles, permisos, ACL); evidencia de que no depende solo de sesión activa |
| 5 | Matriz de endpoints vs controles; pruebas comparativas entre versiones |
| 6 | Evidencia de pruebas (capturas, reportes); registros de respuestas 401/403 |
| 7 | Revisión de parámetros sensibles; evidencia de controles de acceso previos a la resolución del objeto |
| 8 | Arquitectura de control de acceso; uso de middleware, filtros o servicios comunes |
| 9 | Evidencia de deshabilitación; reglas de red, ACL, VPN, allowlists |
| 10 | Pruebas por operación (CRUD); bitácoras de acceso autorizado/denegado |
| 11 | Configuración de logs; reglas SIEM; alertas por acceso indebido |
| 12 | Evidencia de rotación; políticas de credenciales; bitácoras de cambios |

---

# PARTE II — Checklist obligatorio por sistema

> La ATDT requiere un checklist por cada sistema, aplicación o API. Se presentan los tres sistemas evaluados.

---

## SISTEMA 1: SCE – Sistema de Control Escolar

**URL de producción:** [URL]
**Base de datos:** [BD]
**Plataforma:** [PLATAFORMA]

### A. Control de acceso

#### A1. Cada recurso valida autorización a nivel de objeto
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Descripción del mecanismo implementado:**
[Describir la lógica de autorización: cómo se valida que el usuario tiene permiso sobre el objeto solicitado]

**Fragmentos de código o pseudocódigo:**
```
[Incluir fragmento de lógica de autorización]
```

**Evidencia:** [Captura / diagrama / referencia a código]

#### A2. El acceso no depende únicamente de que la sesión esté autenticada
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Descripción:**
[Explicar qué ocurre cuando un usuario autenticado intenta acceder a un recurso para el cual no tiene permiso]

**Evidencia:** [Prueba negativa documentada: acceso denegado a recurso ajeno]

#### A3. No es posible acceder a recursos de terceros modificando identificadores
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Descripción:**
[Explicar qué ocurre cuando se modifica un identificador en URL, body o headers]

**Resultados de pruebas de manipulación:**

| Prueba | Parámetro manipulado | Resultado |
|--------|---------------------|-----------|
| [Descripción] | [Parámetro] | [Rechazado/Aceptado] |

**Evidencia:** [Capturas de solicitudes/respuestas]

#### A4. Se realizan pruebas negativas de autorización (IDOR testing)
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Matriz de pruebas ejecutadas:**

| Prueba | Acción | Resultado esperado | Resultado real |
|--------|--------|-------------------|----------------|
| [Descripción] | [Acción] | [Esperado] | [Real] |

**Evidencia:** [Capturas, reportes, bitácoras]

---

### B. Identificadores

#### B1. Identificadores directos protegidos por validación de pertenencia
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Modelo de validación de pertenencia:**
```
[Diagrama o pseudocódigo del flujo: autenticación → permisos → identificador propio → WHERE]
```

**Evidencia:** [Reglas de validación de pertenencia]

#### B2. UUID, hashes u otros identificadores no sustituyen la autorización
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Descripción:**
[Explicar si se usan UUID/hashes y cómo la autorización es independiente del tipo de identificador]

**Evidencia:** [Pruebas donde identificadores válidos no autorizados son rechazados]

#### B3. No existen identificadores predecibles o reutilizables
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Esquema de generación de identificadores:**
[Describir el tipo de identificadores usados y por qué la enumeración no representa riesgo]

**Evidencia:** [Descripción del esquema]

---

### C. APIs y endpoints

#### C1. Todos los métodos HTTP aplican controles de autorización
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Descripción:**
[Explicar cómo se aplican controles uniformes a GET, POST, PUT, DELETE]

**Matriz de endpoints y métodos:**

| Endpoint / Aplicación | GET | POST | PUT | DELETE | Control aplicado |
|----------------------|-----|------|-----|--------|-----------------|
| [App] | [✅/❌] | [✅/❌] | [✅/❌] | [✅/❌] | [Descripción] |

**Evidencia:** [Matriz completa o referencia]

#### C2. No existen versiones antiguas con controles relajados
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Inventario de versiones activas:**

| Versión / Módulo | Estado | Controles aplicados | Acción |
|-----------------|--------|--------------------|---------| 
| [Versión] | [Activo/Retirado] | [Mismos/Diferentes] | [Ninguna/Retirar/Actualizar] |

**Evidencia:** [Inventario]

#### C3. El cambio de formato no altera el control de acceso
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Descripción:**
[Explicar cómo las exportaciones (.csv, .pdf, .xls) mantienen los mismos controles de autorización]

**Evidencia:** [Pruebas de acceso por formato]

#### C4. La autorización se aplica de forma centralizada y consistente
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Arquitectura del mecanismo centralizado:**
```
[Diagrama del mecanismo: evento centralizado → carga de permisos → aplicación uniforme]
```

**Evidencia:** [Arquitectura o diseño técnico]

---

### D. Flujos secundarios

#### D1. Endpoints secundarios no exponen recursos ajenos
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Flujos revisados:**

| Flujo | Descripción | Controles aplicados |
|-------|-------------|--------------------| 
| Exportación | [Descripción] | [Controles] |
| Notificación | [Descripción] | [Controles] |
| Descarga de archivos | [Descripción] | [Controles] |
| Recuperación | [Descripción] | [Controles] |

**Evidencia:** [Revisión de flujos]

#### D2. No existen IDOR ciegos
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Descripción:**
[Explicar que las acciones con impacto secundario (correos, generación de archivos, cambios de estado) solo afectan recursos del usuario autenticado]

**Evidencia:** [Pruebas funcionales]

---

### E. Operación y monitoreo

#### E1. Rate limiting en endpoints sensibles
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Descripción:**
[Explicar qué mecanismo de rate limiting existe o está en proceso de implementación]

**Configuración:**
```
[Configuración de rate limiting / WAF / mod_ratelimit / etc.]
```

**Evidencia:** [Configuración o plan de acción con plazo]

#### E2. Registro de accesos no autorizados
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Mecanismo de registro:**
[Describir qué se registra, dónde y con qué detalle]

**Extracto de logs:**
```
[Ejemplo de registro de acceso denegado]
```

**Evidencia:** [Extractos de logs]

#### E3. Alertas por patrones de enumeración o acceso anómalo
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Descripción:**
[Describir reglas de monitoreo, SIEM o mecanismo de alertamiento]

**Reglas implementadas:**

| Patrón detectado | Acción | Mecanismo |
|-----------------|--------|-----------|
| [Patrón] | [Acción] | [SIEM/Script/Manual] |

**Evidencia:** [Reglas de monitoreo, reportes de alertas, o plan de acción con plazo]

#### E4. Procedimiento de rotación de credenciales
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Procedimiento documentado:**

| Paso | Acción | Responsable |
|------|--------|-------------|
| 1 | [Acción] | [Responsable] |
| 2 | [Acción] | [Responsable] |
| 3 | [Acción] | [Responsable] |

**Evidencia:** [Procedimiento o registros de rotación]

---

### F. Superficie de exposición

#### F1. Inventario de sistemas/APIs expuestos a Internet
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Inventario:**

| Sistema / Servicio | URL pública | Responsable | Datos que maneja | Nivel de criticidad | Estado operativo |
|-------------------|-------------|-------------|-----------------|---------------------|-----------------|
| [Sistema] | [URL] | [Responsable] | [Tipo datos] | [Alto/Medio/Bajo] | [Activo/Retirado] |

**Evidencia:** [Inventario de activos, escaneo de superficie]

#### F2. Servicios no necesarios fueron retirados, deshabilitados o aislados
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Acciones realizadas:**

| Servicio | Acción tomada | Fecha | Evidencia |
|----------|--------------|-------|-----------|
| [Servicio] | [Retirado/Deshabilitado/Aislado] | [Fecha] | [Config firewall / captura] |

**Evidencia:** [Configuraciones de firewall/WAF, reglas de red, capturas]

#### F3. Servicios restringen acceso a redes autorizadas
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

**Mecanismos de restricción:**

| Servicio | Mecanismo | Redes/IPs autorizadas |
|----------|-----------|----------------------|
| [Servicio] | [Firewall/VPN/ACL/Allowlist] | [Redes] |

**Evidencia:** [Diagramas de red, reglas de firewall/ACL, pruebas de conectividad]

---

## SISTEMA 2: SCE_ASP – Subsistema de Aspirantes

**URL de producción:** [URL]
**Base de datos:** [BD]
**Plataforma:** [PLATAFORMA]

### A. Control de acceso

#### A1. Cada recurso valida autorización a nivel de objeto
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

[MISMA ESTRUCTURA QUE SISTEMA 1 — Llenar para SCE_ASP]

#### A2. El acceso no depende únicamente de que la sesión esté autenticada
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

[LLENAR]

#### A3. No es posible acceder a recursos de terceros modificando identificadores
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

[LLENAR — Incluir hallazgo IDOR y corrección si aplica]

#### A4. Se realizan pruebas negativas de autorización
**Estado:** [CUMPLE / EN PROCESO / NO CUMPLE]

[LLENAR]

### B. Identificadores
#### B1. Identificadores directos protegidos por validación de pertenencia
**Estado:** [LLENAR]
#### B2. UUID, hashes u otros identificadores no sustituyen la autorización
**Estado:** [LLENAR]
#### B3. No existen identificadores predecibles o reutilizables
**Estado:** [LLENAR]

### C. APIs y endpoints
#### C1. Todos los métodos HTTP aplican controles de autorización
**Estado:** [LLENAR]
#### C2. No existen versiones antiguas con controles relajados
**Estado:** [LLENAR]
#### C3. El cambio de formato no altera el control de acceso
**Estado:** [LLENAR]
#### C4. La autorización se aplica de forma centralizada y consistente
**Estado:** [LLENAR]

### D. Flujos secundarios
#### D1. Endpoints secundarios no exponen recursos ajenos
**Estado:** [LLENAR]
#### D2. No existen IDOR ciegos
**Estado:** [LLENAR]

### E. Operación y monitoreo
#### E1. Rate limiting en endpoints sensibles
**Estado:** [LLENAR]
#### E2. Registro de accesos no autorizados
**Estado:** [LLENAR]
#### E3. Alertas por patrones de enumeración o acceso anómalo
**Estado:** [LLENAR]
#### E4. Procedimiento de rotación de credenciales
**Estado:** [LLENAR]

### F. Superficie de exposición
#### F1. Inventario de sistemas/APIs expuestos a Internet
**Estado:** [LLENAR]
#### F2. Servicios no necesarios fueron retirados, deshabilitados o aislados
**Estado:** [LLENAR]
#### F3. Servicios restringen acceso a redes autorizadas
**Estado:** [LLENAR]

---

## SISTEMA 3: SCE_ENBC – Subsistema de Aspirantes ENBC

**URL de producción:** [URL]
**Base de datos:** [BD]
**Plataforma:** [PLATAFORMA]

### A. Control de acceso
#### A1. Cada recurso valida autorización a nivel de objeto
**Estado:** [LLENAR]
#### A2. El acceso no depende únicamente de que la sesión esté autenticada
**Estado:** [LLENAR]
#### A3. No es posible acceder a recursos de terceros modificando identificadores
**Estado:** [LLENAR]
#### A4. Se realizan pruebas negativas de autorización
**Estado:** [LLENAR]

### B. Identificadores
#### B1. Identificadores directos protegidos por validación de pertenencia
**Estado:** [LLENAR]
#### B2. UUID, hashes u otros identificadores no sustituyen la autorización
**Estado:** [LLENAR]
#### B3. No existen identificadores predecibles o reutilizables
**Estado:** [LLENAR]

### C. APIs y endpoints
#### C1. Todos los métodos HTTP aplican controles de autorización
**Estado:** [LLENAR]
#### C2. No existen versiones antiguas con controles relajados
**Estado:** [LLENAR]
#### C3. El cambio de formato no altera el control de acceso
**Estado:** [LLENAR]
#### C4. La autorización se aplica de forma centralizada y consistente
**Estado:** [LLENAR]

### D. Flujos secundarios
#### D1. Endpoints secundarios no exponen recursos ajenos
**Estado:** [LLENAR]
#### D2. No existen IDOR ciegos
**Estado:** [LLENAR]

### E. Operación y monitoreo
#### E1. Rate limiting en endpoints sensibles
**Estado:** [LLENAR]
#### E2. Registro de accesos no autorizados
**Estado:** [LLENAR]
#### E3. Alertas por patrones de enumeración o acceso anómalo
**Estado:** [LLENAR]
#### E4. Procedimiento de rotación de credenciales
**Estado:** [LLENAR]

### F. Superficie de exposición
#### F1. Inventario de sistemas/APIs expuestos a Internet
**Estado:** [LLENAR]
#### F2. Servicios no necesarios fueron retirados, deshabilitados o aislados
**Estado:** [LLENAR]
#### F3. Servicios restringen acceso a redes autorizadas
**Estado:** [LLENAR]

---

# PARTE III — Plan de mejora activo

| # | Elemento pendiente | Sistema(s) afectado(s) | Acción planificada | Responsable | Plazo estimado |
|---|-------------------|----------------------|-------------------|-------------|---------------|
| 1 | [Elemento] | [Sistema] | [Acción] | [Nombre] | [Plazo] |
| 2 | [Elemento] | [Sistema] | [Acción] | [Nombre] | [Plazo] |

---

# PARTE IV — Anexos de evidencia

| Anexo | Descripción | Formato |
|-------|-------------|---------|
| Anexo A | [Descripción] | [PDF/Captura/Código] |
| Anexo B | [Descripción] | [PDF/Captura/Código] |
| Anexo C | [Descripción] | [PDF/Captura/Código] |

---

# Firmas

| Rol | Nombre | Firma | Fecha |
|-----|--------|-------|-------|
| Responsable técnico | [NOMBRE] | | [FECHA] |
| Responsable Institucional de Ciberseguridad | [NOMBRE] | | [FECHA] |
| Titular de la dependencia / Enlace ATDT | [NOMBRE] | | [FECHA] |

---

*Documento elaborado en atención al oficio de la Dirección General de Ciberseguridad de la ATDT, febrero 2026, referente a IDOR / Broken Access Control (OWASP A01).*
