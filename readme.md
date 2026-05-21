# Sistema de Gestión de Aprendices (SGA)

¡Bienvenido al **SGA**! Un sistema web robusto desarrollado en PHP diseñado para centralizar y optimizar la administración de aprendices, instructores, riesgos y observaciones académicas.

---

##  Características Clave

*  **Seguridad Avanzada:** Inicio de sesión con control de acceso estricto y autenticación por roles.
*  **Gestión Integral:** Módulos completos para usuarios, aprendices e instructores.
*  **Evaluación de Riesgos:** Registro automatizado y cálculo del nivel de riesgo académico.
*  **Seguimiento Continuo:** Historial detallado de observaciones por alumno.
*  **Auditoría del Sistema:** Registro minucioso de cada acción realizada en la plataforma.
*  **Panel de Control:** Dashboard interactivo con estadísticas en tiempo real.
*  **Diseño Adaptable:** Interfaz moderna y responsive construida con TailwindCSS.
*  **Auto-Instalación:** Configuración automática de la base de datos en el primer inicio.

---

##  Tecnologías Utilizadas

* **Backend:** PHP 8.x
* **Base de Datos:** MySQL con PDO (Consultas preparadas)
* **Frontend:** HTML5 & TailwindCSS

---

##  Roles del Sistema


| Permisos / Acciones |  Administrador | 👨 Instructor |  Aprendiz |
| :--- | :---: | :---: | :---: |
| Gestionar usuarios y roles | ✅ | ❌ | ❌ |
| Eliminar registros del sistema | ✅ | ❌ | ❌ |
| Ver bitácora de auditoría | ✅ | ❌ | ❌ |
| Crear aprendices / instructores | ✅ | ❌ | ❌ |
| Registrar y editar riesgos | ✅ | ❌ | ❌ |
| Consultar riesgos existentes | ✅ | ✅ | ❌ |
| Registrar y ver observaciones | ✅ | ✅ | ❌ |
| Consultar información permitida | ✅ | ✅ | ✅ |

---

##  Módulos del Sistema

###  Dashboard
* Métrica total de aprendices, instructores, usuarios y riesgos.
* Clasificación visual de riesgos por niveles.

###  Gestión de Usuarios, Aprendices e Instructores
* Operaciones CRUD (Crear, Leer, Actualizar, Eliminar) según el rol asignado.

###  Gestión de Riesgos
* Registro y cálculo inteligente basado en la siguiente fórmula matemática:
  $$\text{Nivel de Riesgo} = \text{Probabilidad} \times \text{Impacto}$$

#### 🚦 Semáforo de Clasificación:
* 🟢 **Bajo** → Zona Segura
* 🟡 **Medio** → En Observación
* 🔴 **Alto** → Alerta Crítica

###  Observaciones y Auditoría
* Historial académico vinculando instructores y alumnos.
* Bitácora de seguridad que registra: inicios de sesión, intentos fallidos y modificaciones de datos.

---

##  Estructura de la Base de Datos

### `usuarios`
* `id` (INT, PK)
* `username` (VARCHAR)
* `password` (VARCHAR)
* `role` (ENUM)

### `aprendices`
* `id` (INT, PK)
* `nombre` (VARCHAR)
* `programa` (VARCHAR)

### `instructores`
* `id` (INT, PK)
* `nombre` (VARCHAR)
* `especialidad` (VARCHAR)

### `riesgos`
* `id` (INT, PK)
* `descripcion` (VARCHAR)
* `nivel` (INT)
* `justificacion` (TEXT)

### `observaciones`
* `id` (INT, PK)
* `aprendiz_id` (INT, FK)
* `texto` (TEXT)
* `autor_id` (INT, FK)

### `auditoria`
* `id` (INT, PK)
* `usuario` (VARCHAR)
* `accion` (VARCHAR)
* `fecha` (DATETIME)

---

##  Instalación y Configuración

Sigue estos sencillos pasos para desplegar el entorno local:

### 1. Clonar el repositorio
```bash
git clone https://github.com
```

### 2. Mover los archivos al servidor local
* **XAMPP:** Copia la carpeta del proyecto en `C:/xampp/htdocs/`
* **Laragon:** Copia la carpeta del proyecto en `C:/laragon/www/`

### 3. Iniciar los servicios
* Abre tu panel de control (XAMPP/Laragon) e inicia los servicios de **Apache** y **MySQL**.

### 4. Ejecutar la aplicación
* Ingresa desde tu navegador web a la siguiente dirección:
  ```http
  http://localhost/New-Gestion-Aprendices
  ```

>  **Nota de Automatización:** No necesitas importar ningún archivo `.sql`. El sistema detectará la ausencia de la base de datos, la creará de forma automática, generará las tablas e insertará al administrador inicial mediante PDO.

---

##  Credenciales de Acceso por Defecto

* **Usuario:** `admin`
* **Contraseña:** `admin123`

---

## Seguridad Implementada

*  Encriptación de contraseñas robusta mediante `password_hash()` y validación con `password_verify()`.
*  Protección contra inyecciones SQL usando sentencias preparadas con **PDO**.
*  Sistema estricto de validación y control de acceso basado en roles.

##  Autor

* **Desarrollador:** Juan Manuel Cardona Molina
a