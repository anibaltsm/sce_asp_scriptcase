# Índice de Documentación - form_recomendantes

Guía completa de todos los archivos y recursos disponibles para implementar el formulario de recomendantes con bloqueo de edición usando `cc_edit`.

---

## 📂 Estructura de archivos

```
form_recomendantes/
├── Eventos/
│   ├── onApplicationInit   (Opcional: validar sesión, ocultar Delete)
│   ├── onLoadRecord        (Deshabilitar campos por fila si cc_edit = 0)
│   ├── OnBeforeUpdate      (Validación backend)
│   └── onAfterUpdate       (Crear usuario y enviar correo)
├── metodos/
│   └── crear_usuario_recomendante(...)
├── README.md               (Documentación general - en raíz)
└── docs/
    ├── INDEX.md            (Este archivo - Índice general)
    ├── DIAGRAMA_FLUJO.md
    ├── NUEVAS_FUNCIONALIDADES.md
    ├── guias/
    │   ├── CODIGOS_EVENTOS_COPIAR_PEGAR.md
    │   ├── CONFIGURACION_SCRIPTCASE_PASO_A_PASO.md
    │   ├── GUIA_DESHABILITAR_CAMPOS_CON_CC_EDIT.md
    │   ├── GUIA_CONFIRMACION_BOTON.md
    │   └── GUIA_APLICAR_CAMBIOS.md
    ├── referencias/
    │   ├── REFERENCIAS_SCRIPTCASE_V9.md
    │   └── ENLACES_DOCUMENTACION_SCRIPTCASE.md
    └── soluciones/
        ├── PROBLEMA_ONAFTERUPDATE_MULTIPLE.md
        ├── SOLUCION_ERRORES_PARSE.md
        ├── SOLUCION_BLOQUEO_POR_FILA.md
        ├── OCULTAR_BOTONES_DELETE.md
        └── SOLUCION_DEFINITIVA_BOTONES.md
```

---

## 📖 Guía de lectura según tu necesidad

### 🚀 Si estás empezando (primera vez)

**Leer en este orden:**

1. **README.md** (raíz) - Visión general del formulario
2. **guias/CONFIGURACION_SCRIPTCASE_PASO_A_PASO.md** - Paso a paso completo
3. **guias/CODIGOS_EVENTOS_COPIAR_PEGAR.md** - Copiar y pegar códigos
4. **guias/GUIA_DESHABILITAR_CAMPOS_CON_CC_EDIT.md** - Entender cómo funciona

---

### ⚡ Si necesitas implementar rápido

**Ir directo a:**

1. **guias/CODIGOS_EVENTOS_COPIAR_PEGAR.md** - Copiar códigos
2. Sección "Checklist" en **guias/CONFIGURACION_SCRIPTCASE_PASO_A_PASO.md**
3. Configurar en Scriptcase siguiendo los pasos

---

### 🔧 Si tienes problemas o errores

**Consultar:**

1. Sección "Problemas comunes" en **guias/CONFIGURACION_SCRIPTCASE_PASO_A_PASO.md**
2. **referencias/ENLACES_DOCUMENTACION_SCRIPTCASE.md** - Buscar en docs oficial
3. Carpeta **soluciones/** - Problemas concretos (onAfterUpdate, parse, botones)
4. **README.md** (raíz) - Sección "Error 'unexpected identifier'"
3. **README.md** - Sección "Error 'unexpected identifier'"

---

### 📚 Si quieres entender la teoría

**Leer:**

1. **guias/GUIA_DESHABILITAR_CAMPOS_CON_CC_EDIT.md** - Teoría y estrategias
2. **referencias/ENLACES_DOCUMENTACION_SCRIPTCASE.md** - Documentación oficial
3. Videos tutoriales (enlaces en referencias/ENLACES_DOCUMENTACION_SCRIPTCASE.md)

---

## 🎯 Archivos principales por tarea

### Tarea: Copiar y pegar eventos en Scriptcase

**Archivo:** `guias/CODIGOS_EVENTOS_COPIAR_PEGAR.md`

**Contenido:**
- ✅ onApplicationInit (opcional)
- ✅ onLoadRecord (clave para deshabilitar campos por fila)
- ✅ OnBeforeUpdate (validación)
- ✅ onAfterUpdate (crear usuario)
- ✅ Método crear_usuario_recomendante
- ✅ WHERE clause
- ✅ Checklist de implementación

---

### Tarea: Configurar Scriptcase paso a paso

**Archivo:** `guias/CONFIGURACION_SCRIPTCASE_PASO_A_PASO.md`

**Contenido:**
- ✅ Requisitos previos
- ✅ PASO 1: Abrir aplicación
- ✅ PASO 2: Configurar campos (Fields)
- ✅ PASO 3: SQL Settings (WHERE)
- ✅ PASO 4: Eventos (Events)
- ✅ PASO 5: Método crear_usuario_recomendante
- ✅ PASO 6: Botones
- ✅ PASO 7: Permisos
- ✅ PASO 8: Probar
- ✅ Qué buscar en documentación oficial
- ✅ Checklist final
- ✅ Problemas comunes y soluciones

---

### Tarea: Entender cómo funciona cc_edit

**Archivo:** `guias/GUIA_DESHABILITAR_CAMPOS_CON_CC_EDIT.md`

**Contenido:**
- ✅ Concepto de cc_edit
- ✅ 3 estrategias para deshabilitar campos
  - Opción 1: onRecord (Recomendado)
  - Opción 2: onLoad
  - Opción 3: onBeforeUpdate
- ✅ Recomendación final: Combinar estrategias
- ✅ Cómo implementar en Scriptcase
- ✅ JSON de ejemplo
- ✅ Métodos útiles de Scriptcase
- ✅ Resumen

---

### Tarea: Buscar en documentación oficial

**Archivo:** `referencias/ENLACES_DOCUMENTACION_SCRIPTCASE.md`

**Contenido:**
- ✅ Enlaces principales (docs español e inglés)
- ✅ Macros específicos con enlaces directos:
  - Field Methods (setReadOnly, setCss)
  - Grid Events (onRecord, onBeforeUpdate)
  - Button Macros (sc_btn_display)
  - Database Macros (sc_lookup, sc_exec_sql)
  - Message Macros (sc_error_message)
  - Mail Macros (sc_mail_send)
  - Security Macros (sc_sql_injection)
- ✅ Videos tutoriales
- ✅ Foro oficial
- ✅ Cómo buscar en docs
- ✅ Términos clave
- ✅ Configuración SMTP Gmail

---

## 🔄 Cambios realizados (Resumen)

### Base de datos
- ✅ Columna `cc_edit_recom` renombrada a `cc_edit`
- ✅ Tipo: TINYINT(1), default 1
- ✅ Base de datos: `sce_asp`

### Archivos actualizados
- ✅ `Eventos/OnBeforeUpdate` - Usa `cc_edit` en lugar de `cc_edit_recom`
- ✅ `metodos/crear_usuario_recomendante` - Actualizado para `cc_edit`
- ✅ `README.md` - Documentación actualizada
- ✅ `data/alter_recomendantes_cc_edit_recom.sql` - Documentado el cambio

### Archivos nuevos / documentación
- ✅ `Eventos/onLoadRecord` - Deshabilitar campos por fila
- ✅ `docs/guias/` - Códigos, configuración paso a paso, guías
- ✅ `docs/referencias/` - Scriptcase v9, enlaces oficiales
- ✅ `docs/soluciones/` - Problemas resueltos
- ✅ `docs/INDEX.md` - Este archivo

---

## 📋 Checklist de implementación rápida

Marca al completar cada paso:

- [ ] 1. **Leer** `guias/CODIGOS_EVENTOS_COPIAR_PEGAR.md`
- [ ] 2. **Abrir** Scriptcase → form_recomendantes
- [ ] 3. **Agregar** campo `cc_edit` como Hidden en Fields
- [ ] 4. **Copiar** código de `onLoadRecord` y pegar en Scriptcase
- [ ] 5. **Copiar** código de `OnBeforeUpdate` y pegar
- [ ] 6. **Copiar** código de `onAfterUpdate` y pegar
- [ ] 7. **Verificar** método `crear_usuario_recomendante`
- [ ] 8. **Configurar** WHERE clause con `[id_asp]`
- [ ] 9. **Generar** código (Generate Source Code)
- [ ] 10. **Desplegar** aplicación
- [ ] 11. **Probar** con usuario aspirante
- [ ] 12. **Verificar** que campos se deshabilitan cuando `cc_edit = 0`

---

## 🎓 Niveles de conocimiento

### Nivel 1: Básico (Solo copiar y pegar)
**Archivos necesarios:**
- `guias/CODIGOS_EVENTOS_COPIAR_PEGAR.md`
- Checklist en `guias/CONFIGURACION_SCRIPTCASE_PASO_A_PASO.md`

**Tiempo estimado:** 30-45 minutos

---

### Nivel 2: Intermedio (Entender y personalizar)
**Archivos necesarios:**
- `guias/CODIGOS_EVENTOS_COPIAR_PEGAR.md`
- `guias/CONFIGURACION_SCRIPTCASE_PASO_A_PASO.md`
- `guias/GUIA_DESHABILITAR_CAMPOS_CON_CC_EDIT.md`

**Tiempo estimado:** 1-2 horas

---

### Nivel 3: Avanzado (Dominar y extender)
**Archivos necesarios:**
- Todos los anteriores
- `referencias/ENLACES_DOCUMENTACION_SCRIPTCASE.md`
- Documentación oficial de Scriptcase

**Tiempo estimado:** 2-4 horas (incluye estudio)

---

## 🆘 Soporte y ayuda

### Si tienes problemas:

1. **Buscar** en "Problemas comunes" de `guias/CONFIGURACION_SCRIPTCASE_PASO_A_PASO.md`
2. **Consultar** carpeta `soluciones/` y `referencias/ENLACES_DOCUMENTACION_SCRIPTCASE.md`
3. **Revisar** el código de eventos en `guias/CODIGOS_EVENTOS_COPIAR_PEGAR.md`
4. **Preguntar** en el foro de Scriptcase

### Recursos de ayuda:

- Foro Scriptcase: https://www.scriptcase.net/forum/
- Docs oficial: https://www.scriptcase.net/docs/
- Email soporte: support@scriptcase.net

---

## 📊 Flujo del sistema

```
Usuario aspirante → Login
    ↓
Menu aspirante → Clic en "Recomendantes"
    ↓
form_recomendantes se carga
    ↓
onApplicationInit: Valida [id_asp]
    ↓
WHERE clause: Filtra 3 recomendantes del aspirante
    ↓
onLoadRecord (por cada fila):
    - Si cc_edit = 0 → Deshabilitar campos (gris)
    - Si cc_edit = 1 → Campos editables (blanco)
    ↓
Usuario edita y hace clic en Guardar
    ↓
OnBeforeUpdate:
    - Valida cc_edit
    - Si cc_edit = 0 → Error, no guardar
    - Si cc_edit = 1 → Continuar
    ↓
UPDATE en BD (guardar cambios)
    ↓
onAfterUpdate:
    - Llama crear_usuario_recomendante
    - Crea usuario en sec_asp_users
    - Asigna grupo 7
    - Actualiza cc_edit = 0
    - Envía correo con datos de acceso
    ↓
Próximo cargue:
    - onLoadRecord detecta cc_edit = 0
    - Campos deshabilitados (gris)
    - No se puede editar más
```

---

## 🚀 Siguiente pasos después de implementar

Una vez que el formulario funcione:

1. **Probar** con diferentes usuarios aspirantes
2. **Verificar** que los correos se envían correctamente
3. **Revisar** logs de errores (si hay)
4. **Personalizar** estilos CSS según diseño del sistema
5. **Documentar** cualquier cambio adicional
6. **Capacitar** a usuarios finales

---

## 📅 Control de versiones

| Versión | Fecha | Cambio | Archivo |
|---------|-------|--------|---------|
| 1.0 | Feb 2026 | Cambio cc_edit_recom → cc_edit | Base de datos |
| 1.1 | Feb 2026 | Actualización eventos y métodos | Eventos/ |
| 1.2 | Feb 2026 | Documentación completa | Todos los .md |

---

## 📞 Contacto

Para preguntas sobre este proyecto específico:
- Revisar archivos de documentación en esta carpeta
- Consultar README.md para información general

Para preguntas sobre Scriptcase:
- Documentación oficial: https://www.scriptcase.net/docs/
- Foro: https://www.scriptcase.net/forum/
- Soporte: support@scriptcase.net

---

**Última actualización:** Febrero 2026

**Nota:** Mantén este índice actualizado si agregas o modificas archivos en el futuro.
