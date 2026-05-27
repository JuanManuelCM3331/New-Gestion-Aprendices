<?php

$config = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'db' => 'gestion_aprendices'
);

try {
    $db = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['db'], $config['user'], $config['pass']);
} catch (PDOException $e) {
    $driverCode = $e->errorInfo[1] ?? null;
    if ($driverCode == 1049 || str_contains($e->getMessage(), 'Unknown database')) {
        $tmp = new PDO("mysql:host=" . $config['host'] . ";", $config['user'], $config['pass']);
        $tmp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $tmp->exec("CREATE DATABASE IF NOT EXISTS `" . $config['db'] . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $db = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['db'], $config['user'], $config['pass']);
    } else {
        throw $e;
    }
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$page = $_GET['page'] ?? 'dashboard';

$db->exec("CREATE TABLE IF NOT EXISTS usuarios (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50), password VARCHAR(255), role ENUM('admin', 'instructor', 'aprendiz'))");
$db->exec("CREATE TABLE IF NOT EXISTS aprendices (id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(100), programa VARCHAR(100), usuario_id INT NULL)");
// Asegurar columna de relación existe en instalaciones previas
try {
    $db->exec("ALTER TABLE aprendices ADD COLUMN IF NOT EXISTS usuario_id INT NULL");
} catch (Exception $e) {
    // Si la versión de MySQL no soporta IF NOT EXISTS, ignorar el error
}
$db->exec("CREATE TABLE IF NOT EXISTS instructores (id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(100), especialidad VARCHAR(100))");
$db->exec("CREATE TABLE IF NOT EXISTS riesgos (id INT AUTO_INCREMENT PRIMARY KEY, descripcion VARCHAR(255), nivel INT, justificacion TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS observaciones (id INT AUTO_INCREMENT PRIMARY KEY, aprendiz_id INT, texto TEXT, autor_id INT)");
$db->exec("CREATE TABLE IF NOT EXISTS auditoria (id INT AUTO_INCREMENT PRIMARY KEY, usuario VARCHAR(100), accion TEXT, fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
?>