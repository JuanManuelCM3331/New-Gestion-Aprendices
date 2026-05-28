# Gestion Aprendices

Sistema integral para la gestión de aprendices, instructores, observaciones y evaluación de riesgos en un contexto educativo. Este proyecto forma parte de un trabajo de ciberseguridad y DevOps.

## Descripción General

**Gestion Aprendices** es una aplicación web desarrollada en PHP que permite:
- Gestionar usuarios del sistema con diferentes roles
- Administrar aprendices y su información
- Registrar instructores y asignar especialidades
- Crear observaciones y seguimiento de aprendices
- Evaluar riesgos con un sistema de clasificación
- Mantener un registro de auditoría de todas las acciones

## 🔧 Requisitos

- **PHP:** >= 7.4 (Actualmente usa PHP 8.2)
- **Base de Datos:** MySQL >= 5.7 o MariaDB >= 10.2
- **Servidor Web:** Apache, Nginx, etc.
- **Docker:** (Opcional, para containerización)
- **Composer:** (Opcional, para dependencias)

## Instalación

### Opción 1: Con Docker Compose (Recomendado)

```bash
# Clonar el repositorio
git clone https://github.com/JuanManuelCM3331/New-Gestion-Aprendices.git
cd New-Gestion-Aprendices

# Crear archivo .env con las variables de entorno
cp .env.example .env

# Levantar los servicios
docker-compose up -d
```

Acceder a la aplicación en: `http://localhost:8080`

### Opción 2: Instalación Manual

```bash
# 1. Clonar el repositorio
git clone https://github.com/JuanManuelCM3331/New-Gestion-Aprendices.git
cd New-Gestion-Aprendices

# 2. Configurar base de datos
# Editar App/Modules/Dashboard/db.php y actualizar credenciales:
```

```php
$config = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'db' => 'gestion_aprendices'
);
```

```bash
# 3. Acceder a la aplicación
http://localhost/New-Gestion-Aprendices/App/Modules/Dashboard/login.php
```

## Credenciales por Defecto

- **Usuario:** admin
- **Contraseña:** admin123

**Nota de Seguridad:** Cambiar las credenciales por defecto inmediatamente después de la instalación.

## Estructura del Proyecto

```
New-Gestion-Aprendices/
├── App/
│   ├── index.php
│   └── Modules/
│       ├── Dashboard/
│       │   ├── login.php              # Sistema de autenticación
│       │   ├── dashboard.php          # Panel principal
│       │   ├── db.php                 # Configuración de BD
│       │   ├── crud.php               # Operaciones de BD
│       │   ├── auditoria.php          # Log de auditoría
│       │   ├── gestionUsuarios.php    # Gestión de usuarios
│       │   ├── gestionAprendices.php  # Gestión de aprendices
│       │   ├── gestionInstructores.php # Gestión de instructores
│       │   ├── gestionRiesgos.php     # Gestión de riesgos
│       │   └── observaciones.php      # Gestión de observaciones
│       └── ValoradorRiesgo/
│           └── calcularRiesgo.php     # Lógica de cálculo de riesgos
├── Dockerfile                         # Configuración Docker
├── docker-compose.yml                 # Orquestación de servicios
├── .gitignore
└── readme.md
```

## Características Principales

### Panel Administrador
- ✅ Gestión de usuarios (crear, ver, actualizar, eliminar)
- ✅ Gestión de aprendices y su información
- ✅ Gestión de instructores y especialidades
- ✅ Gestión de riesgos con clasificación
- ✅ Visualización del log de auditor��a
- ✅ Control total del sistema

### Panel Instructor
- ✅ Ver listado de aprendices asignados
- ✅ Crear observaciones para aprendices
- ✅ Consultar información de riesgos

### Panel Aprendiz
- ✅ Ver observaciones asignadas
- ✅ Consultar información de riesgos asociados

## Modelo de Base de Datos

### Tabla `usuarios`
- `id` (PK) - Identificador único
- `username` - Nombre de usuario
- `password` - Contraseña hasheada
- `role` - Rol del usuario (admin, instructor, aprendiz)

### Tabla `aprendices`
- `id` (PK)
- `nombre` - Nombre del aprendiz
- `programa` - Programa educativo
- `usuario_id` (FK) - Referencia a usuarios

### Tabla `instructores`
- `id` (PK)
- `nombre` - Nombre del instructor
- `especialidad` - Área de especialización

### Tabla `riesgos`
- `id` (PK)
- `descripcion` - Descripción del riesgo
- `nivel` - Nivel de severidad
- `justificacion` - Justificación del riesgo

### Tabla `observaciones`
- `id` (PK)
- `aprendiz_id` (FK) - Referencia a aprendices
- `texto` - Contenido de la observación
- `autor_id` (FK) - Referencia a usuarios (autor)

### Tabla `auditoria`
- `id` (PK)
- `usuario` - Usuario que realiza la acción
- `accion` - Descripción de la acción
- `fecha` - Timestamp de la acción

## Características de Seguridad

- ✅ Hashing de contraseñas con `PASSWORD_DEFAULT`
- ✅ Consultas preparadas para prevenir SQL injection
- ✅ Autenticación basada en sesiones
- ✅ Control de acceso basado en roles (RBAC)
- ✅ Sistema completo de auditoría
- ✅ Validación de entrada en formularios
- ✅ Protección contra CSRF mediante tokens de sesión

## Docker

### Configuración Docker Compose

El proyecto incluye configuración para ejecutarse con Docker:

```yaml
services:
  app:           # Servicio PHP 8.2 con Apache
  db:            # MySQL 8.0
```

**Variables de entorno (.env):**
- `DB_ROOT_PASSWORD` - Contraseña root de MySQL
- `DB_NAME` - Nombre de la base de datos
- `DB_USER` - Usuario de MySQL
- `DB_PASS` - Contraseña del usuario de BD

## Uso

1. **Iniciar sesión** con las credenciales por defecto
2. **Cambiar contraseña** recomendado en primer acceso
3. **Navegar** según el rol asignado
4. **Crear registros** de aprendices, instructores y observaciones
5. **Consultar auditoría** para seguimiento de actividades

## Flujo de Riesgos

1. El sistema calcula automáticamente el nivel de riesgo
2. Los riesgos se clasifican por nivel de severidad
3. Las observaciones se vinculan a evaluaciones de riesgo
4. Todo queda registrado en auditoría

## Desarrollo

### Estructura de módulos
- Cada módulo es independiente dentro de Dashboard
- Los ficheros de gestión (gestion*.php) manejan la interfaz
- CRUD centralizado en crud.php
- Configuración de BD en db.php

### Extensión del sistema
Para añadir nuevas funcionalidades:
1. Crear nuevo archivo en `App/Modules/Dashboard/`
2. Agregar funciones CRUD en `crud.php`
3. Actualizar logs de auditoría
4. Documentar cambios

## Soporte

Para reportar problemas, sugerencias o preguntas, por favor crea un [issue](https://github.com/JuanManuelCM3331/New-Gestion-Aprendices/issues) en el repositorio.

## Autor

**Juan Manuel Cardona Molina**
- Proyecto de Ciberseguridad y DevOps
- [Perfil GitHub](https://github.com/JuanManuelCM3331)

## Licencia

Para más información, contactar con el autor.

---

**Última actualización:** Mayo 28, 2026
