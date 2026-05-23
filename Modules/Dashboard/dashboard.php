<?php
require_once __DIR__ . '/crud.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../ValoradorRiesgo/calcularRiesgo.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

    <!--++++++++++++++++++++++++++++ Login ++++++++++++++++++++++++++++-->
    <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
    <?php if (!isset($_SESSION['user'])): ?>
        <div class="min-h-screen w-full flex items-center justify-center bg-slate-100 px-4 relative overflow-hidden">
            <!-- Fondo decorativo -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-200/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-slate-300/30 rounded-full blur-3xl"></div>
            </div>
            <!-- Login -->
            <div class="relative z-10 w-full max-w-md bg-white/90 backdrop-blur-sm
                   border border-slate-200 rounded-3xl shadow-2xl p-8
                   transition duration-300 hover:shadow-blue-100">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="mx-auto mb-4 w-16 h-16 rounded-2xl
                           bg-slate-900 text-white flex items-center justify-center
                           text-2xl font-bold shadow-lg">
                    </div>
                    <h2 class="text-3xl font-bold text-slate-800">
                        SGA Login
                    </h2>
                    <p class="text-slate-500 mt-2 text-sm">
                        Sistema de Gestión Académica
                    </p>
                </div>
                <!-- Error -->
                <?php if (!empty($loginError)): ?>
                    <div class="mb-5 px-4 py-3 rounded-xl
                           bg-red-50 border border-red-200
                           text-red-700 text-sm">

                        <?= htmlspecialchars($loginError) ?>
                    </div>
                <?php endif; ?>
                <!-- Formulario -->
                <form method="POST" action="?action=login" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">
                            Usuario
                        </label>
                        <input name="user" placeholder="Ingresa tu usuario" required class="w-full px-4 py-3 rounded-xl border border-slate-300
                               bg-slate-50 transition
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               hover:border-blue-400 hover:bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">
                            Contraseña
                        </label>
                        <input name="pass" type="password" placeholder="Ingresa tu contraseña" required class="w-full px-4 py-3 rounded-xl border border-slate-300
                               bg-slate-50 transition
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               hover:border-blue-400 hover:bg-white">
                    </div>
                    <button class="w-full py-3 rounded-xl bg-slate-900 text-white
                           font-semibold tracking-wide
                           transition duration-300
                           hover:bg-blue-600 hover:shadow-lg hover:-translate-y-0.5">
                        Entrar al sistema
                    </button>
                </form>
                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-slate-400">
                        Plataforma administrativa · SGA
                    </p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
        <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

        <!--++++++++++++++++++++++++++ Barra lateral ++++++++++++++++++++++++++-->
        <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
        <aside class="w-64 bg-slate-900 text-slate-300 p-6 flex flex-col h-screen border-r border-slate-800 font-sans">
            <h1 class="text-xl font-extrabold text-white tracking-wide mb-8 flex flex-col gap-1">
                <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider">Sistema</span>
                SGA | <span
                    class="text-slate-400 font-medium text-sm mt-0.5"><?= htmlspecialchars($_SESSION['user']['role']) ?></span>
            </h1>

            <nav class="space-y-1.5 flex-1">
                <a href="?page=dashboard"
                    class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-slate-800 hover:text-white">Dashboard</a>

                <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                    <a href="?page=usuarios"
                        class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-slate-800 hover:text-white">Gestión
                        Usuarios</a>
                    <a href="?page=aprendices"
                        class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-slate-800 hover:text-white">Aprendices</a>
                    <a href="?page=instructores"
                        class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-slate-800 hover:text-white">Instructores</a>
                    <a href="?page=auditoria"
                        class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-slate-800 hover:text-white">Auditoría</a>
                <?php endif; ?>

                <a href="?page=riesgos"
                    class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-slate-800 hover:text-white">Riesgos</a>
                <a href="?page=observaciones"
                    class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-slate-800 hover:text-white">Observaciones</a>

                <div class="pt-4 mt-4 border-t border-slate-800">
                    <a href="?action=logout"
                        class="block px-4 py-2.5 rounded-lg text-sm font-medium text-rose-400 transition-all duration-200 hover:bg-rose-500/10 hover:text-rose-300">Cerrar
                        sesión</a>
                </div>
            </nav>
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
        </aside>
        <main class="flex-1 p-8 overflow-y-auto">
            <?php if ($page == 'dashboard'): ?>
                <div class="grid grid-cols-4 gap-4 mb-8">
                    <?php foreach (['aprendices', 'instructores', 'riesgos', 'usuarios'] as $t): ?>
                        <div
                            class="px-3 pt-8 pb-10 text-center rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden z-10 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <span class="block text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">
                                <?= ucfirst($t) ?>
                            </span>
                            <span class="block text-3xl font-extrabold">
                                <?= $db->query("SELECT count(*) FROM $t")->fetchColumn() ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div
                    class="grid grid-cols-1 sm:grid-cols-4 gap-3 p-4 bg-slate-50/50 rounded-xl border border-slate-200 shadow-sm content-start gap-6">
                    <?php foreach ($db->query("SELECT * FROM riesgos") as $r):
                        $color = ($r['nivel'] >= 6) ? 'red' : (($r['nivel'] >= 3) ? 'yellow' : 'green'); ?>
                        <div
                            class=" bg-<?= $color ?>-500 p-4 border-l-8 border-l-<?= $color ?>-600 rounded-r-full border-4 transition-all duration-300 hover:scale-110 shadow-xl text-white">
                            <p class="font-bold"><?= $r['descripcion'] ?></p>
                            <p class="text-xs text-white font-bold">Nivel: <?= $r['nivel'] ?></p>
                            <p class="text-xs text-white font-bold">Descripción: <?= $r['justificacion'] ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

            <?php if ($page == 'usuarios' && $_SESSION['user']['role'] == 'admin'): ?>
                <!-- Crear Usuario -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-6 transition hover:shadow-md">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-800">Crear Usuario</h2>
                            <p class="text-sm text-slate-500">Registra nuevos usuarios en el sistema</p>
                        </div>
                    </div>
                    <form method="POST" action="?page=usuarios&action=crear_usuario"
                        class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">
                                Usuario
                            </label>
                            <input name="u" placeholder="Ingresa el usuario" required class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           transition hover:border-blue-400 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">
                                Contraseña
                            </label>
                            <input name="p" type="password" placeholder="Ingresa la contraseña" required class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           transition hover:border-blue-400 hover:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">
                                Rol
                            </label>
                            <select name="r" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           transition hover:border-blue-400 hover:bg-white">

                                <option value="admin">Admin</option>
                                <option value="instructor">Instructor</option>
                                <option value="aprendiz">Aprendiz</option>
                            </select>
                        </div>
                        <div class="md:col-span-3 pt-2">
                            <button class="w-full md:w-auto px-6 py-3 rounded-xl bg-slate-900 text-white
                           font-medium transition duration-200
                           hover:bg-blue-600 hover:shadow-lg hover:-translate-y-0.5">
                                Crear usuario
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabla Usuarios -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 transition hover:shadow-md">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-800">Listado de usuarios</h2>
                            <p class="text-sm text-slate-500">Usuarios registrados actualmente</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto rounded-xl border border-slate-200">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-600">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">ID</th>
                                    <th class="px-4 py-3 font-semibold">Usuario</th>
                                    <th class="px-4 py-3 font-semibold">Rol</th>
                                    <th class="px-4 py-3 font-semibold">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php foreach ($db->query("SELECT id, username, role FROM usuarios") as $u): ?>
                                    <tr class="transition hover:bg-slate-50">
                                        <td class="px-4 py-3 text-slate-700">
                                            <?= $u['id'] ?>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-slate-800">
                                            <?= htmlspecialchars($u['username']) ?>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                                <?= htmlspecialchars($u['role']) ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                                <a href="?page=usuarios&action=del&tabla=usuarios&id=<?= $u['id'] ?>" class="inline-flex items-center px-3 py-1.5 rounded-lg
                                               text-red-600 bg-red-50 border border-red-100
                                               transition hover:bg-red-100 hover:text-red-700">
                                                    Eliminar
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php endif; ?>
            <?php if ($page == 'aprendices' && in_array($_SESSION['user']['role'], ['admin', 'instructor'])): ?>
                <!-- Formulario -->
                <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-6 transition hover:shadow-md">
                        <div class="mb-5">
                            <h2 class="text-xl font-semibold text-slate-800">
                                Registrar Aprendiz
                            </h2>
                            <p class="text-sm text-slate-500">
                                Agrega nuevos aprendices al sistema
                            </p>
                        </div>
                        <form method="POST" action="?page=aprendices&action=crear_aprendiz"
                            class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Nombre
                                </label>
                                <input name="nombre" placeholder="Nombre del aprendiz" required class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition hover:border-blue-400 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Programa
                                </label>
                                <input name="prog" placeholder="Programa de formación" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition hover:border-blue-400 hover:bg-white">
                            </div>
                            <div class="flex items-end">
                                <button class="w-full px-5 py-3 rounded-xl bg-slate-900 text-white
                               font-medium transition duration-200
                               hover:bg-blue-600 hover:shadow-lg hover:-translate-y-0.5">
                                    Registrar aprendiz
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
                <!-- Tabla -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 transition hover:shadow-md">

                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-800">
                                Listado de aprendices
                            </h2>

                            <p class="text-sm text-slate-500">
                                Aprendices registrados actualmente
                            </p>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-slate-200">

                        <table class="w-full text-sm text-left">

                            <thead class="bg-slate-50 text-slate-600">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">
                                        Nombre
                                    </th>

                                    <th class="px-4 py-3 font-semibold">
                                        Programa
                                    </th>

                                    <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                        <th class="px-4 py-3 font-semibold">
                                            Acciones
                                        </th>
                                    <?php endif; ?>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                <?php foreach ($db->query("SELECT * FROM aprendices") as $a): ?>

                                    <tr class="transition hover:bg-slate-50">

                                        <td class="px-4 py-4 font-medium text-slate-800">
                                            <?= htmlspecialchars($a['nombre']) ?>
                                        </td>

                                        <td class="px-4 py-4 text-slate-600">
                                            <?= htmlspecialchars($a['programa']) ?>
                                        </td>

                                        <?php if ($_SESSION['user']['role'] == 'admin'): ?>

                                            <td class="px-4 py-4">

                                                <a href="?page=aprendices&action=del&tabla=aprendices&id=<?= $a['id'] ?>" class="inline-flex items-center px-3 py-1.5 rounded-lg
                                               text-red-600 bg-red-50 border border-red-100
                                               transition hover:bg-red-100 hover:text-red-700">

                                                    Eliminar
                                                </a>

                                            </td>

                                        <?php endif; ?>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            <?php endif; ?>

            <?php if ($page == 'instructores' && $_SESSION['user']['role'] == 'admin'): ?>

                <!-- Formulario -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-6 transition hover:shadow-md">

                    <div class="mb-5">
                        <h2 class="text-xl font-semibold text-slate-800">
                            Crear Instructor
                        </h2>

                        <p class="text-sm text-slate-500">
                            Registra nuevos instructores en el sistema
                        </p>
                    </div>

                    <form method="POST" action="?page=instructores&action=crear_instructor"
                        class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">
                                Nombre
                            </label>

                            <input name="nombre" placeholder="Nombre del instructor" required class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           transition hover:border-blue-400 hover:bg-white">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">
                                Especialidad
                            </label>

                            <input name="esp" placeholder="Especialidad" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           transition hover:border-blue-400 hover:bg-white">
                        </div>

                        <div class="flex items-end">
                            <button class="w-full px-5 py-3 rounded-xl bg-slate-900 text-white
                           font-medium transition duration-200
                           hover:bg-blue-600 hover:shadow-lg hover:-translate-y-0.5">

                                Agregar instructor
                            </button>
                        </div>

                    </form>

                </div>


                <!-- Tabla -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 transition hover:shadow-md">

                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-800">
                                Listado de instructores
                            </h2>

                            <p class="text-sm text-slate-500">
                                Instructores registrados actualmente
                            </p>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-slate-200">

                        <table class="w-full text-sm text-left">

                            <thead class="bg-slate-50 text-slate-600">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">
                                        Nombre
                                    </th>

                                    <th class="px-4 py-3 font-semibold">
                                        Especialidad
                                    </th>

                                    <th class="px-4 py-3 font-semibold">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                <?php foreach ($db->query("SELECT * FROM instructores") as $i): ?>

                                    <tr class="transition hover:bg-slate-50">

                                        <td class="px-4 py-4 font-medium text-slate-800">
                                            <?= htmlspecialchars($i['nombre']) ?>
                                        </td>

                                        <td class="px-4 py-4 text-slate-600">
                                            <?= htmlspecialchars($i['especialidad']) ?>
                                        </td>

                                        <td class="px-4 py-4">

                                            <a href="?page=instructores&action=del&tabla=instructores&id=<?= $i['id'] ?>" class="inline-flex items-center px-3 py-1.5 rounded-lg
                                           text-red-600 bg-red-50 border border-red-100
                                           transition hover:bg-red-100 hover:text-red-700">

                                                Eliminar
                                            </a>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            <?php endif; ?>

            <?php if ($page == 'auditoria' && $_SESSION['user']['role'] == 'admin'): ?>

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 transition hover:shadow-md">

                    <!-- Encabezado -->
                    <div class="flex items-center justify-between mb-5">

                        <div>
                            <h2 class="text-xl font-semibold text-slate-800">
                                Registro de Auditoría
                            </h2>

                            <p class="text-sm text-slate-500">
                                Historial reciente de acciones realizadas en el sistema
                            </p>
                        </div>

                    </div>


                    <!-- Tabla -->
                    <div class="overflow-x-auto rounded-xl border border-slate-200">

                        <table class="w-full text-sm text-left">

                            <thead class="bg-slate-50 text-slate-600">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">
                                        Fecha
                                    </th>

                                    <th class="px-4 py-3 font-semibold">
                                        Usuario
                                    </th>

                                    <th class="px-4 py-3 font-semibold">
                                        Acción
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                <?php foreach ($db->query("SELECT * FROM auditoria ORDER BY fecha DESC LIMIT 100") as $log): ?>

                                    <tr class="transition hover:bg-slate-50">

                                        <td class="px-4 py-4 text-slate-600 whitespace-nowrap">
                                            <?= htmlspecialchars($log['fecha']) ?>
                                        </td>

                                        <td class="px-4 py-4">

                                            <span class="inline-flex items-center px-3 py-1 rounded-full
                                             text-xs font-medium bg-blue-100 text-blue-700">

                                                <?= htmlspecialchars($log['usuario']) ?>

                                            </span>

                                        </td>

                                        <td class="px-4 py-4 text-slate-700">
                                            <?= htmlspecialchars($log['accion']) ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            <?php endif; ?>

            <?php if ($page == 'riesgos'): ?>

                <?php
                $editRisk = null;

                if (isset($_GET['edit']) && $_SESSION['user']['role'] === 'admin') {
                    $stmt = $db->prepare('SELECT * FROM riesgos WHERE id = ?');
                    $stmt->execute([$_GET['edit']]);
                    $editRisk = $stmt->fetch();
                }
                ?>


                <!-- Formulario -->
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>

                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-6 transition hover:shadow-md">

                        <div class="mb-5">

                            <h2 class="text-xl font-semibold text-slate-800">
                                <?= $editRisk ? 'Editar Riesgo' : 'Registrar Riesgo' ?>
                            </h2>

                            <p class="text-sm text-slate-500">
                                <?= $editRisk
                                    ? 'Actualiza la información del riesgo seleccionado'
                                    : 'Registra nuevos riesgos dentro del sistema'; ?>
                            </p>

                        </div>

                        <form method="POST" action="?page=riesgos&action=<?= $editRisk ? 'editar_riesgo' : 'crear_riesgo' ?>"
                            class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- Descripción -->
                            <div class="md:col-span-2">

                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Descripción
                                </label>

                                <input name="desc" placeholder="Describe el riesgo" required
                                    value="<?= $editRisk ? htmlspecialchars($editRisk['descripcion']) : '' ?>" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                               focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500
                               transition hover:border-red-400 hover:bg-white">

                            </div>

                            <!-- Probabilidad -->
                            <div>

                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Probabilidad (1-3)
                                </label>

                                <input type="number" name="prob" min="1" max="3" required placeholder="Nivel de probabilidad"
                                    value="<?= $editRisk ? max(1, min(3, ceil($editRisk['nivel'] / 2))) : '' ?>" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                               focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500
                               transition hover:border-red-400 hover:bg-white">

                            </div>

                            <!-- Impacto -->
                            <div>

                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Impacto (1-3)
                                </label>

                                <input type="number" name="imp" min="1" max="3" required placeholder="Nivel de impacto"
                                    value="<?= $editRisk ? max(1, min(3, ceil($editRisk['nivel'] / 2))) : '' ?>" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                               focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500
                               transition hover:border-red-400 hover:bg-white">

                            </div>

                            <!-- Justificación -->
                            <div class="md:col-span-2">

                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Justificación
                                </label>

                                <textarea name="just" rows="4" required placeholder="Justificación del riesgo"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                               focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500
                               transition hover:border-red-400 hover:bg-white"><?= $editRisk ? htmlspecialchars($editRisk['justificacion']) : '' ?></textarea>

                            </div>

                            <?php if ($editRisk): ?>
                                <input type="hidden" name="id" value="<?= $editRisk['id'] ?>">
                            <?php endif; ?>

                            <!-- Botón -->
                            <div class="md:col-span-2">

                                <button class="w-full md:w-auto px-6 py-3 rounded-xl bg-slate-900 text-white
                               font-medium transition duration-200
                               hover:bg-red-600 hover:shadow-lg hover:-translate-y-0.5">

                                    <?= $editRisk ? 'Actualizar riesgo' : 'Guardar riesgo' ?>

                                </button>

                            </div>

                        </form>

                    </div>

                <?php endif; ?>


                <!-- Tabla -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 transition hover:shadow-md">

                    <div class="flex items-center justify-between mb-5">

                        <div>
                            <h2 class="text-xl font-semibold text-slate-800">
                                Listado de riesgos
                            </h2>

                            <p class="text-sm text-slate-500">
                                Riesgos registrados actualmente en el sistema
                            </p>
                        </div>

                    </div>

                    <div class="overflow-x-auto rounded-xl border border-slate-200">

                        <table class="w-full text-sm text-left">

                            <thead class="bg-slate-50 text-slate-600">

                                <tr>

                                    <th class="px-4 py-3 font-semibold">
                                        Descripción
                                    </th>

                                    <th class="px-4 py-3 font-semibold">
                                        Nivel
                                    </th>

                                    <th class="px-4 py-3 font-semibold">
                                        Justificación
                                    </th>

                                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                        <th class="px-4 py-3 font-semibold">
                                            Acciones
                                        </th>
                                    <?php endif; ?>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                <?php foreach ($db->query("SELECT * FROM riesgos") as $r): ?>

                                    <?php
                                    $badge =
                                        ($r['nivel'] >= 6)
                                        ? 'bg-red-100 text-red-700'
                                        : (($r['nivel'] >= 3)
                                            ? 'bg-yellow-100 text-yellow-700'
                                            : 'bg-green-100 text-green-700');
                                    ?>

                                    <tr class="transition hover:bg-slate-50">

                                        <td class="px-4 py-4 font-medium text-slate-800">
                                            <?= htmlspecialchars($r['descripcion']) ?>
                                        </td>

                                        <td class="px-4 py-4">

                                            <span class="inline-flex items-center px-3 py-1 rounded-full
                                             text-xs font-semibold <?= $badge ?>">

                                                Nivel <?= $r['nivel'] ?>

                                            </span>

                                        </td>

                                        <td class="px-4 py-4 text-slate-600 max-w-md">
                                            <?= htmlspecialchars($r['justificacion']) ?>
                                        </td>

                                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>

                                            <td class="px-4 py-4">

                                                <div class="flex gap-2">

                                                    <a href="?page=riesgos&edit=<?= $r['id'] ?>" class="inline-flex items-center px-3 py-1.5 rounded-lg
                                                   text-blue-600 bg-blue-50 border border-blue-100
                                                   transition hover:bg-blue-100 hover:text-blue-700">

                                                        Editar
                                                    </a>

                                                    <a href="?page=riesgos&action=del&tabla=riesgos&id=<?= $r['id'] ?>" class="inline-flex items-center px-3 py-1.5 rounded-lg
                                                   text-red-600 bg-red-50 border border-red-100
                                                   transition hover:bg-red-100 hover:text-red-700">

                                                        Eliminar
                                                    </a>

                                                </div>

                                            </td>

                                        <?php endif; ?>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            <?php endif; ?>

            <?php if ($page == 'observaciones'): ?>

                <!-- Formulario -->
                <?php if ($_SESSION['user']['role'] === 'instructor'): ?>

                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-6 transition hover:shadow-md">

                        <div class="mb-5">

                            <h2 class="text-xl font-semibold text-slate-800">
                                Registrar observación
                            </h2>

                            <p class="text-sm text-slate-500">
                                Registra anotaciones y seguimientos de los aprendices
                            </p>

                        </div>

                        <form method="POST" action="?page=observaciones&action=crear_observacion" class="grid grid-cols-1 gap-4">

                            <!-- Aprendiz -->
                            <div>

                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Aprendiz
                                </label>

                                <select name="aprendiz_id" required class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition hover:border-blue-400 hover:bg-white">

                                    <option value="">
                                        Seleccionar aprendiz
                                    </option>

                                    <?php foreach ($db->query("SELECT id, nombre FROM aprendices") as $a): ?>

                                        <option value="<?= $a['id'] ?>">
                                            <?= htmlspecialchars($a['nombre']) ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                            <!-- Observación -->
                            <div>

                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Observación
                                </label>

                                <textarea name="texto" rows="5" required placeholder="Escribe la observación" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition hover:border-blue-400 hover:bg-white"></textarea>

                            </div>

                            <!-- Botón -->
                            <div>

                                <button class="w-full md:w-auto px-6 py-3 rounded-xl bg-slate-900 text-white
                               font-medium transition duration-200
                               hover:bg-blue-600 hover:shadow-lg hover:-translate-y-0.5">

                                    Guardar observación

                                </button>

                            </div>

                        </form>

                    </div>

                <?php endif; ?>


                <!-- Tabla -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 transition hover:shadow-md">

                    <div class="flex items-center justify-between mb-5">

                        <div>
                            <h2 class="text-xl font-semibold text-slate-800">
                                Observaciones
                            </h2>

                            <p class="text-sm text-slate-500">
                                Historial de observaciones registradas en el sistema
                            </p>
                        </div>

                    </div>


                    <div class="overflow-x-auto rounded-xl border border-slate-200">

                        <table class="w-full text-sm text-left">

                            <thead class="bg-slate-50 text-slate-600">

                                <tr>

                                    <th class="px-4 py-3 font-semibold">
                                        Aprendiz
                                    </th>

                                    <th class="px-4 py-3 font-semibold">
                                        Observación
                                    </th>

                                    <th class="px-4 py-3 font-semibold">
                                        Autor
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                <?php
                                $sql = "SELECT o.*, a.nombre AS aprendiz_nombre, u.username AS autor_nombre 
                            FROM observaciones o 
                            LEFT JOIN aprendices a ON o.aprendiz_id = a.id 
                            LEFT JOIN usuarios u ON o.autor_id = u.id";

                                foreach ($db->query($sql) as $obs):
                                    ?>

                                    <tr class="transition hover:bg-slate-50">

                                        <!-- Aprendiz -->
                                        <td class="px-4 py-4">

                                            <span class="inline-flex items-center px-3 py-1 rounded-full
                                             text-xs font-medium bg-blue-100 text-blue-700">

                                                <?= htmlspecialchars($obs['aprendiz_nombre'] ?? 'Desconocido') ?>

                                            </span>

                                        </td>

                                        <!-- Observación -->
                                        <td class="px-4 py-4 text-slate-700 max-w-xl">
                                            <?= htmlspecialchars($obs['texto']) ?>
                                        </td>

                                        <!-- Autor -->
                                        <td class="px-4 py-4 text-slate-600 font-medium">
                                            <?= htmlspecialchars($obs['autor_nombre'] ?? 'Sistema') ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            <?php endif; ?>
        </main>
    <?php endif; ?>
</body>

</html>