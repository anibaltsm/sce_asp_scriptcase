# Guía: Implementar .env Dinámico con Pipelines

Esta guía explica cómo implementar la estrategia de generación dinámica de `.env` en proyectos Flutter Web, eliminando el `.env` del repositorio y permitiendo diferentes configuraciones por entorno.

## 📋 Problema que Resuelve

### ❌ Antes:
- `.env` commiteado al repositorio (riesgo de seguridad)
- Misma configuración para todos los entornos
- Difícil cambiar valores sin modificar repositorio

### ✅ Después:
- `.env` generado dinámicamente por pipeline
- Diferentes valores por entorno (beta, prod)
- Archivo `.env.example` como referencia para desarrolladores

---

## 🚀 Implementación (4 Pasos)

### Paso 1: Crear .env.example

Crear archivo `.env.example` en la raíz del proyecto con valores de referencia:

```env
# Configuración de variables de entorno para [NOMBRE_PROYECTO]
# Copia este archivo a .env y actualiza las URLs según el entorno

# URL del servicio principal
MI_SERVICIO_URL=https://mi-servicio.tysonbeta.com

# URL del servicio secundario
OTRO_SERVICIO_URL=https://otro-servicio.tysonbeta.com

# Nota: En CI/CD estos valores se generan automáticamente por el pipeline
# Para desarrollo local, crea un archivo .env copiando este ejemplo
```

### Paso 2: Actualizar .gitignore y Eliminar .env del Repositorio

**2.1 Actualizar `.gitignore`:**
```gitignore
# Variables de entorno (generadas dinámicamente en CI/CD)
.env

# Mantener .env.example como referencia
!.env.example
```

**2.2 Eliminar .env del repositorio:**
```bash
# Si .env ya está commiteado, eliminarlo
git rm --cached .env

# Commitear el cambio
git add .gitignore .env.example
git commit -m "#[WorkItemId]: eliminar .env del repositorio y agregar .env.example"
```

### Paso 3: Configurar Pipelines Azure DevOps

#### 3.1 Pipeline Beta (`azure-pipelines_beta.yml`)

**Agregar variables:**
```yaml
variables:
  # ... otras variables existentes ...

  # Variables de entorno para la aplicación
  MI_SERVICIO_URL: https://mi-servicio.tysonbeta.com
  OTRO_SERVICIO_URL: https://otro-servicio.tysonbeta.com
```

**Agregar step para generar .env (ANTES del Docker Build):**
```yaml
  - job: DockerBuild
    displayName: Docker Build And Publish Image
    dependsOn:
    - PrepareK8S
    steps:
      # ⬇️ AGREGAR ESTE STEP AQUÍ
      - bash: |
          echo "Generating .env file for Flutter Web..."
          cat > .env << EOF
          MI_SERVICIO_URL=$(MI_SERVICIO_URL)
          OTRO_SERVICIO_URL=$(OTRO_SERVICIO_URL)
          EOF

          echo "Generated .env content:"
          cat .env
        workingDirectory: $(Build.SourcesDirectory)
        displayName: 'Generate .env file'
      # ⬆️ FIN DEL STEP

      # Aquí continúan los steps existentes de Docker Build
      - task: Docker@2
        displayName: 'Build Docker Image'
        # ...
```

#### 3.2 Pipeline Prod (`azure-pipelines_prod.yml`)

**Mismo proceso pero con URLs de producción:**
```yaml
variables:
  # ... otras variables existentes ...

  # Variables de entorno para producción
  MI_SERVICIO_URL: https://mi-servicio.tysonprod.com
  OTRO_SERVICIO_URL: https://otro-servicio.tysonprod.com
```

**Agregar el mismo step de generación de .env:**
```yaml
      - bash: |
          echo "Generating .env file for Flutter Web..."
          cat > .env << EOF
          MI_SERVICIO_URL=$(MI_SERVICIO_URL)
          OTRO_SERVICIO_URL=$(OTRO_SERVICIO_URL)
          EOF

          echo "Generated .env content:"
          cat .env
        workingDirectory: $(Build.SourcesDirectory)
        displayName: 'Generate .env file'
```

### Paso 4: Desarrollo Local

**Para trabajar localmente:**
```bash
# Copiar .env.example a .env
cp .env.example .env

# Editar .env con las URLs que necesites (beta, local, etc.)
nano .env

# Ejecutar la aplicación
flutter run -d chrome
```

---

## ✅ Checklist de Implementación

### Configuración Básica
- [ ] Crear `.env.example` con valores de referencia
- [ ] Actualizar `.gitignore` para ignorar `.env`
- [ ] Eliminar `.env` del repositorio (`git rm --cached .env`)

### Pipelines
- [ ] Agregar variables de entorno en `azure-pipelines_beta.yml`
- [ ] Agregar variables de entorno en `azure-pipelines_prod.yml`
- [ ] Agregar step de generación de `.env` ANTES de Docker build en ambos pipelines

### Validación
- [ ] Copiar `.env.example` → `.env` localmente
- [ ] Ejecutar `flutter run -d chrome` (debe funcionar)
- [ ] Hacer commit y push a rama de prueba
- [ ] Verificar que pipeline genera `.env` correctamente
- [ ] Verificar que deploy funciona en ambiente de prueba

---

## 📝 Ejemplo Completo

### Proyecto con 2 Variables

#### `.env.example`
```env
# Configuración para CRM Web Reportes COA
CRM_AGENTE_NOTIFICACIONES_SERVICE=https://crm-agente-notificaciones-service.tysonbeta.com/v1
CRM_AGENTE_LLAMADAS_SERVICE=https://crm-agente-llamadas-service.tysonbeta.com
```

#### Pipeline Beta
```yaml
variables:
  ClusterNamespace: 'web'
  DockerImageName: 'mi-proyecto'
  # ... otras variables ...

  # Variables de entorno
  CRM_AGENTE_NOTIFICACIONES_SERVICE: https://crm-agente-notificaciones-service.tysonbeta.com/v1
  CRM_AGENTE_LLAMADAS_SERVICE: https://crm-agente-llamadas-service.tysonbeta.com

stages:
- stage: CI
  jobs:
  - job: DockerBuild
    displayName: Docker Build And Publish Image
    steps:
      - bash: |
          echo "Generating .env file for Flutter Web..."
          cat > .env << EOF
          CRM_AGENTE_NOTIFICACIONES_SERVICE=$(CRM_AGENTE_NOTIFICACIONES_SERVICE)
          CRM_AGENTE_LLAMADAS_SERVICE=$(CRM_AGENTE_LLAMADAS_SERVICE)
          EOF

          echo "Generated .env content:"
          cat .env
        workingDirectory: $(Build.SourcesDirectory)
        displayName: 'Generate .env file'

      - task: Docker@2
        displayName: 'Build Docker Image'
        # ...
```

#### Pipeline Prod
```yaml
variables:
  # ... variables comunes ...

  # Variables de producción
  CRM_AGENTE_NOTIFICACIONES_SERVICE: https://crm-agente-notificaciones-service.tysonprod.com/v1
  CRM_AGENTE_LLAMADAS_SERVICE: https://crm-agente-llamadas-service.tysonprod.com

stages:
- stage: CI
  jobs:
  - job: DockerBuild
    steps:
      # Mismo step de generación
      - bash: |
          cat > .env << EOF
          CRM_AGENTE_NOTIFICACIONES_SERVICE=$(CRM_AGENTE_NOTIFICACIONES_SERVICE)
          CRM_AGENTE_LLAMADAS_SERVICE=$(CRM_AGENTE_LLAMADAS_SERVICE)
          EOF
        displayName: 'Generate .env file'
```

---

## 🔍 Cómo Usar las Variables en el Código

El código sigue usando `dotenv.env` normalmente:

```dart
import 'package:flutter_dotenv/flutter_dotenv.dart';

class ApiService {
  static String buildUrl() {
    final baseUrl = dotenv.env['MI_SERVICIO_URL']!;
    return '$baseUrl/api/v1/endpoint';
  }
}
```

---

## 🛠️ Troubleshooting

### Error: "No se pudo cargar .env"

**Causa**: Falta crear el archivo `.env` localmente

**Solución**:
```bash
cp .env.example .env
```

### Pipeline falla en Docker build

**Causa**: El step de generación de `.env` no se ejecutó o está en el orden incorrecto

**Solución**: Verificar que el step está ANTES del Docker build en el pipeline

### Variables no se actualizan en producción

**Causa**: Las variables están definidas solo en beta

**Solución**: Asegurarse de definir las variables en AMBOS pipelines (beta y prod)

---

## 📚 Ventajas de Esta Estrategia

### 🔒 Seguridad
- `.env` nunca se commitea al repositorio
- Diferentes valores por entorno
- Variables sensibles solo en Azure DevOps

### 🚀 Flexibilidad
- Fácil cambiar valores sin modificar código
- Configuración independiente por entorno
- Nuevos desarrolladores saben qué configurar (`.env.example`)

### 👥 Colaboración
- `.env.example` documenta variables requeridas
- Setup local más fácil
- Menos errores de configuración

---

## 📎 Archivos del Proyecto de Referencia

- **Proyecto**: `crm-web-reportes-coa`
- **Commits relevantes**:
  - `#83032: actualizar variables de entorno y validaciones de reportes`
  - `#83032: agregar .env.example y fix manifest.json`
- **Pull Request**: #119689

---

**Autor**: Anibal Sanchez
**Fecha**: 2026-03-05
**Versión**: 1.0
