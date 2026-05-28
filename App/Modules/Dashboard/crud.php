<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../ValoradorRiesgo/calcularRiesgo.php';

session_start();

// Admin por defecto - Usar credenciales del .env
$defaultAdminUser = getenv('DEFAULT_ADMIN_USER') ?: 'admin';
$defaultAdminPass = getenv('DEFAULT_ADMIN_PASS') ?: 'admin123';
if ($db->query("SELECT count(*) FROM usuarios")->fetchColumn() == 0)
    $db->exec("INSERT INTO usuarios (username, password, role) VALUES ('" . $defaultAdminUser . "', '" . password_hash($defaultAdminPass, PASSWORD_DEFAULT) . "', 'admin')");

// Lógica de Procesamiento
$loginError = '';
$action = $_GET['action'] ?? null;
$role = $_SESSION['user']['role'] ?? null;
$page = $_GET['page'] ?? 'dashboard';
$allowedTables = ['usuarios', 'aprendices', 'instructores', 'riesgos'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action) {
    if ($action === 'login') {
        $u = $db->prepare("SELECT * FROM usuarios WHERE username = ?");
        $u->execute([$_POST['user']]);
        $user = $u->fetch();
        if ($user && password_verify($_POST['pass'], $user['password'])) {
            $_SESSION['user'] = $user;
            $db->prepare("INSERT INTO auditoria (usuario, accion) VALUES (?, 'Login exitoso')")->execute([$user['username']]);
            header('Location: ?page=dashboard');
            exit;
        }
        $db->prepare("INSERT INTO auditoria (usuario, accion) VALUES (?, 'Login fallido')")->execute([$_POST['user']]);
        $loginError = 'Usuario o clave incorrecto';
    }

    if ($role === 'admin') {
        if ($action === 'crear_usuario') {
            $db->prepare("INSERT INTO usuarios (username, password, role) VALUES (?,?,?)")->execute([$_POST['u'], password_hash($_POST['p'], PASSWORD_DEFAULT), $_POST['r']]);
            $uid = $db->lastInsertId();
            // Si es aprendiz, crear entrada en aprendices vinculada
            if ($_POST['r'] === 'aprendiz') {
                $db->prepare("INSERT INTO aprendices (nombre, programa, usuario_id) VALUES (?,?,?)")->execute([$_POST['u'], '', $uid]);
            }
            $auditAction = 'Creó usuario con rol: ' . $_POST['r'];
            $db->prepare("INSERT INTO auditoria (usuario, accion) VALUES (?, ?)")->execute([$_SESSION['user']['username'], $auditAction]);
        }
        if ($action === 'crear_aprendiz') {
            $nombre = trim($_POST['nombre']);
            $base = preg_replace('/\s+/', '_', strtolower($nombre));
            $username = $base;
            $stmt = $db->prepare("SELECT count(*) FROM usuarios WHERE username = ?");
            $stmt->execute([$username]);
            $cnt = $stmt->fetchColumn();
            $i = 1;
            while ($cnt > 0) {
                $username = $base . $i;
                $stmt->execute([$username]);
                $cnt = $stmt->fetchColumn();
                $i++;
            }
            $defaultAprendizPass = getenv('DEFAULT_APRENDIZ_PASS') ?: 'aprendiz123';
            $password = $defaultAprendizPass;
            $db->prepare("INSERT INTO usuarios (username, password, role) VALUES (?,?,?)")->execute([$username, password_hash($password, PASSWORD_DEFAULT), 'aprendiz']);
            $uid = $db->lastInsertId();
            $db->prepare("INSERT INTO aprendices (nombre, programa, usuario_id) VALUES (?,?,?)")->execute([$nombre, $_POST['prog'], $uid]);
            $auditAction = 'Creó aprendiz: ' . $nombre . ' usuario: ' . $username;
            $db->prepare("INSERT INTO auditoria (usuario, accion) VALUES (?, ?)")->execute([$_SESSION['user']['username'], $auditAction]);
        }
        if ($action === 'crear_instructor') {
            $db->prepare("INSERT INTO instructores (nombre, especialidad) VALUES (?,?)")->execute([$_POST['nombre'], $_POST['esp']]);
            $auditAction = 'Creó instructor: ' . $_POST['nombre'];
            $db->prepare("INSERT INTO auditoria (usuario, accion) VALUES (?, ?)")->execute([$_SESSION['user']['username'], $auditAction]);
        }
        if ($action === 'crear_riesgo') {
            $db->prepare("INSERT INTO riesgos (descripcion, nivel, justificacion) VALUES (?,?,?)")->execute([$_POST['desc'], (int) $_POST['prob'] * (int) $_POST['imp'], $_POST['just']]);
            $auditAction = 'Creó riesgo: ' . $_POST['desc'];
            $db->prepare("INSERT INTO auditoria (usuario, accion) VALUES (?, ?)")->execute([$_SESSION['user']['username'], $auditAction]);
        }
        if ($action === 'editar_riesgo' && isset($_POST['id'])) {
            $db->prepare("UPDATE riesgos SET descripcion = ?, nivel = ?, justificacion = ? WHERE id = ?")->execute([$_POST['desc'], (int) $_POST['prob'] * (int) $_POST['imp'], $_POST['just'], $_POST['id']]);
            $auditAction = 'Editó riesgo ID: ' . $_POST['id'];
            $db->prepare("INSERT INTO auditoria (usuario, accion) VALUES (?, ?)")->execute([$_SESSION['user']['username'], $auditAction]);
        }
        if ($action === 'crear_observacion') {
            $db->prepare("INSERT INTO observaciones (aprendiz_id, texto, autor_id) VALUES (?,?,?)")->execute([$_POST['aprendiz_id'], $_POST['texto'], $_SESSION['user']['id']]);
            $auditAction = 'Creó observación para aprendiz ID: ' . $_POST['aprendiz_id'];
            $db->prepare("INSERT INTO auditoria (usuario, accion) VALUES (?, ?)")->execute([$_SESSION['user']['username'], $auditAction]);
        }
        header('Location: ?page=' . $page);
        exit;
    }

    if ($action === 'crear_observacion' && $role === 'instructor') {
        $db->prepare("INSERT INTO observaciones (aprendiz_id, texto, autor_id) VALUES (?,?,?)")->execute([$_POST['aprendiz_id'], $_POST['texto'], $_SESSION['user']['id']]);
        $auditAction = 'Instructor creó observación para aprendiz ID: ' . $_POST['aprendiz_id'];
        $db->prepare("INSERT INTO auditoria (usuario, accion) VALUES (?, ?)")->execute([$_SESSION['user']['username'], $auditAction]);
        header('Location: ?page=observaciones');
        exit;
    }
}

// Manejo de eliminación (GET link)
if ($action === 'del' && isset($_SESSION['user']) && $role === 'admin') {
    $table = $_GET['tabla'] ?? '';
    $id = $_GET['id'] ?? null;
    if ($id && in_array($table, $allowedTables, true)) {
        if ($table === 'usuarios') {
            $stmt = $db->prepare("SELECT role FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            $userToDelete = $stmt->fetch();
            if ($userToDelete && $userToDelete['role'] === 'aprendiz') {
                $db->prepare("DELETE FROM aprendices WHERE usuario_id = ?")->execute([$id]);
            }
            $db->prepare("DELETE FROM usuarios WHERE id = ?")->execute([$id]);
        } elseif ($table === 'aprendices') {
            $stmt = $db->prepare("SELECT usuario_id FROM aprendices WHERE id = ?");
            $stmt->execute([$id]);
            $apr = $stmt->fetch();
            if ($apr && !empty($apr['usuario_id'])) {
                $db->prepare("DELETE FROM usuarios WHERE id = ?")->execute([$apr['usuario_id']]);
            }
            $db->prepare("DELETE FROM aprendices WHERE id = ?")->execute([$id]);
        } else {
            $db->prepare("DELETE FROM $table WHERE id = ?")->execute([$id]);
        }
        $auditAction = 'Eliminó ' . $table . ' ID: ' . $id;
        $db->prepare("INSERT INTO auditoria (usuario, accion) VALUES (?, ?)")->execute([$_SESSION['user']['username'], $auditAction]);
    }
    header('Location: ?page=' . $page);
    exit;
}

if ($action === 'logout') {
    session_destroy();
    header('Location: ?');
    exit;
}
?>