<?php
try {
    $db = new PDO("mysql:host=localhost", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("CREATE DATABASE IF NOT EXISTS sistema_gestion");
    $db->exec("USE sistema_gestion");
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$page = $_GET['page'] ?? 'dashboard';

$db->exec("CREATE TABLE IF NOT EXISTS usuarios (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50), password VARCHAR(255), role ENUM('admin', 'instructor', 'aprendiz'))");
$db->exec("CREATE TABLE IF NOT EXISTS aprendices (id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(100), programa VARCHAR(100))");
$db->exec("CREATE TABLE IF NOT EXISTS instructores (id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(100), especialidad VARCHAR(100))");
$db->exec("CREATE TABLE IF NOT EXISTS riesgos (id INT AUTO_INCREMENT PRIMARY KEY, descripcion VARCHAR(255), nivel INT, justificacion TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS observaciones (id INT AUTO_INCREMENT PRIMARY KEY, aprendiz_id INT, texto TEXT, autor_id INT)");
$db->exec("CREATE TABLE IF NOT EXISTS auditoria (id INT AUTO_INCREMENT PRIMARY KEY, usuario VARCHAR(50), accion VARCHAR(255), fecha DATETIME DEFAULT CURRENT_TIMESTAMP)");
?>