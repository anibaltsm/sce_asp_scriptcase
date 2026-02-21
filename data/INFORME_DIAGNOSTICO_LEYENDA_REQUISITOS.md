# Diagnóstico: Leyendas incorrectas en form_asp_requisitos_1 (Número de requisito)

**Fecha:** Feb 2026  
**Aspirante de prueba:** id_asp_FK = 1278  
**Problema:** Las descripciones de los requisitos ("Número de requisito") muestran leyendas de EBC mezcladas o incorrectas.

---

## Resumen ejecutivo

La consulta que alimenta la columna **"Número de requisito"** no filtra por tipo de programa. Hay **dos convocatorias activas** (EBC id_prog=9 y posgrado 2026), y la consulta **sin filtro** devuelve **ambas** para cada `num_req`, mezclando leyendas.

**Solución:** Agregar el filtro  
`AND (id_prog_FK<>9 OR ISNULL(id_prog_FK))`  
a la consulta.

---

## Datos de la BD (verificados)

### 1. Aspirante 1278

- **Generación:** 2026 (posgrado)
- Sus requisitos (`id_lisreq_FK` 139-153) pertenecen a la convocatoria **posgrado 2026** (id_prog_FK = NULL).

### 2. Convocatorias activas (cc_activa=1)

| id_conv | generación | id_prog_FK | Programa |
|---------|------------|------------|----------|
| 11      | 2025       | 9          | EBC      |
| 12      | 2026       | NULL       | Posgrado |

### 3. Diferencia entre las leyendas

Para **num_req = 1** (ejemplo):

| Sin filtro (actual) | Con filtro (propuesto) |
|---------------------|-------------------------|
| Mezcla: "EBC Carta postulación..." + "Carta de solicitud..." | Solo: "Carta de solicitud de admisión (En formato PDF)" |
| (2 filas: EBC + posgrado) | (1 fila: posgrado 2026) |

Para **num_req = 2**:

| Sin filtro | Con filtro (correcto para 1278) |
|------------|----------------------------------|
| "Carta de solicitud exponiendo motivos..." (EBC) + "Carta compromiso académico..." (posgrado) | "Carta compromiso de un académico o académica para dirigir el Proyecto de Tesis (En formato PDF)" |

El aspirante 1278 es de **posgrado 2026**, por tanto las leyendas correctas son las de la convocatoria 12, no las de EBC (9).

---

## Consulta actual (incorrecta)

```sql
SELECT sc_concat(' - ', leyenda) 
FROM convocatorias_posg
INNER JOIN sce.list_req_gral ON convocatorias_posg.id_conv = list_req_gral.id_conv_FK
WHERE cc_activa=1 
  AND list_req_gral.num_requisito= {num_req}
```

**Problema:** Devuelve 2 filas por cada `num_req` (EBC + posgrado). `sc_concat` junta ambas leyendas y se ve mal o confuso.

---

## Consulta corregida (recomendada)

```sql
SELECT sc_concat(' - ', leyenda) 
FROM convocatorias_posg
INNER JOIN sce.list_req_gral ON convocatorias_posg.id_conv = list_req_gral.id_conv_FK
WHERE cc_activa=1 
  AND (id_prog_FK<>9 OR ISNULL(id_prog_FK))
  AND list_req_gral.num_requisito= {num_req}
```

**Efecto:** Excluye la convocatoria EBC (id_prog_FK=9) y devuelve solo la leyenda de posgrado, que es la que corresponde al aspirante 1278 y a otros aspirantes de posgrado.

---

## Dónde cambiar la consulta en ScriptCase

1. Abrir el proyecto en ScriptCase.
2. Ir a **form_asp_requisitos_1** → **Form Settings** (o Configuración del formulario).
3. Buscar el campo **"Número de requisito"** (o columna que muestra la descripción).
4. Si el campo está definido por **consulta SQL** o **Lookup**, editar la consulta y añadir:  
   `AND (id_prog_FK<>9 OR ISNULL(id_prog_FK))`  
   en el `WHERE`.
5. Regenerar código y desplegar.

> **Nota:** En ScriptCase la consulta puede estar en:
> - Form → Fields → [campo Número de requisito] → Source / SQL / Lookup
> - O en una consulta asociada (Query) que se usa como fuente del campo.

---

## Consistencia con el resto del proyecto

La corrección es coherente con:

- **add_asp_aspirantes** (alta de aspirantes): usa el filtro `id_prog_FK<>9`.
- **OnAfterUpdate** de form_asp_requisitos_1: usa el filtro para la generación activa.
- **consultas_verificar_requisitos_recomendantes.sql**: ya incluye el filtro.

---

## Script de diagnóstico usado

Se ejecutó `data/sql_diagnostico_leyenda_requisitos.sql` contra la BD para obtener estos resultados.
