Usuario: admin

Contraseña: admin123

Sistema de Gestión de Aprendices (SGA)

Sistema web desarrollado en PHP para la administración de aprendices, instructores, riesgos y observaciones académicas.
Incluye autenticación por roles, auditoría de acciones y panel administrativo.

Características
Inicio de sesión con control de acceso.
Gestión de usuarios.
Gestión de aprendices.
Gestión de instructores.
Registro y evaluación de riesgos.
Registro de observaciones.
Auditoría de acciones del sistema.
Dashboard con estadísticas.
Interfaz responsive con TailwindCSS.
Base de datos creada automáticamente.
Tecnologías utilizadas
PHP
MySQL
PDO
TailwindCSS
HTML5
Roles del sistema
Administrador

Puede:

Crear usuarios.
Crear aprendices.
Crear instructores.
Registrar riesgos.
Editar riesgos.
Eliminar registros.
Ver auditoría.
Ver observaciones.
Instructor

Puede:

Ver aprendices.
Registrar observaciones.
Consultar riesgos.
Consultar observaciones.
Aprendiz

Puede:

Iniciar sesión.
Consultar información permitida por el sistema.
Módulos del sistema
Dashboard

Muestra:

Total de aprendices.
Total de instructores.
Total de riesgos.
Total de usuarios.
Riesgos clasificados por nivel.
Gestión de usuarios

Permite:

Crear usuarios.
Asignar roles.
Consultar usuarios registrados.
Gestión de aprendices

Permite:

Registrar aprendices.
Consultar aprendices.
Eliminar aprendices.
Gestión de instructores

Permite:

Registrar instructores.
Consultar instructores.
Eliminar instructores.
Gestión de riesgos

Permite:

Registrar riesgos.
Calcular nivel de riesgo.
Editar riesgos.
Eliminar riesgos.
Fórmula del nivel de riesgo

Nivel de Riesgo=Probabilidad×Impacto

Clasificación
Bajo → Verde
Medio → Amarillo
Alto → Rojo
Observaciones

Permite:

Registrar observaciones para aprendices.
Asociar observaciones a instructores.
Consultar historial de observaciones.
Auditoría

Registra:

Inicios de sesión.
Intentos fallidos.
Creación de registros.
Eliminación de registros.
Edición de información.
Estructura de la base de datos
Tabla usuarios
Campo	Tipo
id	INT
username	VARCHAR
password	VARCHAR
role	ENUM
Tabla aprendices
Campo	Tipo
id	INT
nombre	VARCHAR
programa	VARCHAR
Tabla instructores
Campo	Tipo
id	INT
nombre	VARCHAR
especialidad	VARCHAR
Tabla riesgos
Campo	Tipo
id	INT
descripcion	VARCHAR
nivel	INT
justificacion	TEXT
Tabla observaciones
Campo	Tipo
id	INT
aprendiz_id	INT
texto	TEXT
autor_id	INT
Tabla auditoria
Campo	Tipo
id	INT
usuario	VARCHAR
accion	VARCHAR
fecha	DATETIME
Instalación
1. Clonar el proyecto
git clone URL_DEL_REPOSITORIO
2. Mover el proyecto

Copiar el archivo del sistema dentro de:

XAMPP
htdocs/
Laragon
www/
3. Iniciar servicios

Iniciar:

Apache
MySQL
4. Ejecutar el sistema

Abrir en el navegador:

http://localhost/
Credenciales por defecto
Administrador
Usuario: admin
Contraseña: admin123
Funcionamiento automático

El sistema:

Crea automáticamente la base de datos.
Crea automáticamente las tablas.
Inserta un administrador inicial.
Configura la conexión mediante PDO.
Seguridad implementada
Uso de password_hash().
Uso de password_verify().
Protección básica mediante consultas preparadas.
Validación de roles.
Registro de auditoría.
Mejoras futuras
Recuperación de contraseña.
Exportación de reportes PDF.
Dashboard avanzado con gráficas.
Sistema de notificaciones.
Gestión de fichas y programas.
API REST.
Arquitectura modular MVC.
Integración con JWT.
Autor

Desarrollado por Juan Manuel Cardona Molina.# New-Gestion-Aprendices
