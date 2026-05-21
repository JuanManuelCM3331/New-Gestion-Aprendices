# Gestion Aprendices

This is a system for managing apprentices and their risk assessment in an educational context.

## Requirements

- PHP >= 7.4
- MySQL >= 5.7 or MariaDB >= 10.2
- Web Server (Apache, Nginx, etc)
- Composer (optional, for dependencies)

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/JuanManuelCM3331/New-Gestion-Aprendices.git
cd New-Gestion-Aprendices
```

### 2. Create the database

The application will create the necessary tables automatically on first run.

### 3. Configure the database connection

Edit `Modules/Dashboard/db.php` and update the credentials:

```php
$config = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'db' => 'gestion_aprendices'
);
```

### 4. Access the application

Point your web browser to `http://localhost/New-Gestion-Aprendices/Modules/Dashboard/dashboard.php`

## Default Credentials

- **Username:** admin
- **Password:** admin123

## Features

### Admin Panel
- User management (create, view, delete users)
- Apprentice management
- Instructor management
- Risk management with classification system
- Audit log of all system activities

### Instructor Panel
- View apprentices
- Create observations for apprentices

### Apprentice Panel
- View assigned observations
- View risk information

## Directory Structure

```
Modules/
├── Dashboard/
│   ├── crud.php          # Database operations
│   ├── db.php            # Database configuration
│   └── dashboard.php     # Main UI
└── ValoradorRiesgo/
    └── calcularRiesgo.php # Risk calculation logic
```

## Database Schema

### usuarios
- id (PK)
- username
- password
- role (admin, instructor, aprendiz)

### aprendices
- id (PK)
- nombre
- programa
- usuario_id (FK to usuarios)

### instructores
- id (PK)
- nombre
- especialidad

### riesgos
- id (PK)
- descripcion
- nivel
- justificacion

### observaciones
- id (PK)
- aprendiz_id (FK to aprendices)
- texto
- autor_id (FK to usuarios)

### auditoria
- id (PK)
- usuario
- accion
- fecha (timestamp)

## Security Features

- Password hashing with PASSWORD_DEFAULT
- SQL prepared statements for injection prevention
- Session-based authentication
- Role-based access control
- Comprehensive audit logging

## Support

For issues or questions, please create an issue in the repository.

##  Autor

 * **Desarrollador:** Juan Manuel Cardona Molina