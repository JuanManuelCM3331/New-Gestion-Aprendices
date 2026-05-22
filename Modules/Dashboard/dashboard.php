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
        <div class="m-auto bg-white p-8 rounded shadow-xl w-80">
            <h2 class="font-bold mb-4">SGA Login</h2>
            <?php if (!empty($loginError)): ?>
                <div class="mb-4 p-2 bg-red-100 text-red-700 rounded"><?= htmlspecialchars($loginError) ?></div>
            <?php endif; ?>
            <form method="POST" action="?action=login">
                <input name="user" class="border p-2 w-full mb-2" placeholder="Usuario" required>
                <input name="pass" type="password" class="border p-2 w-full mb-4" placeholder="Clave" required>
                <button class="bg-blue-600 text-white w-full p-2">Entrar</button>
            </form>
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
                        <div class=" bg-<?= $color ?>-500 p-4 border-l-8 border-l-<?= $color ?>-600 rounded-r-full border-4 transition-all duration-300 hover:scale-110 shadow-xl text-white">
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
                <div class="bg-white p-4 shadow rounded mb-4">
                    <h2 class="font-bold mb-3">Crear Usuario</h2>
                    <form method="POST" action="?page=usuarios&action=crear_usuario" class="grid grid-cols-3 gap-2">
                        <input name="u" placeholder="Usuario" class="border p-2" required>
                        <input name="p" type="password" placeholder="Contraseña" class="border p-2" required>
                        <select name="r" class="border p-2">
                            <option value="admin">Admin</option>
                            <option value="instructor">Instructor</option>
                            <option value="aprendiz">Aprendiz</option>
                        </select>
                        <button class="col-span-3 bg-blue-600 text-white p-2">Crear usuario</button>
                    </form>
                </div>
                <div class="bg-white p-4 shadow rounded">
                    <h2 class="font-bold mb-3">Listado de usuarios</h2>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="p-2 border">ID</th>
                                <th class="p-2 border">Usuario</th>
                                <th class="p-2 border">Rol</th>
                                <th class="p-2 border">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($db->query("SELECT id, username, role FROM usuarios") as $u): ?>
                                <tr>
                                    <td class="p-2 border"><?= $u['id'] ?></td>
                                    <td class="p-2 border"><?= htmlspecialchars($u['username']) ?></td>
                                    <td class="p-2 border"><?= htmlspecialchars($u['role']) ?></td>
                                    <td class="p-2 border">
                                        <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                            <a href="?page=usuarios&action=del&tabla=usuarios&id=<?= $u['id'] ?>"
                                                class="text-red-500">Eliminar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if ($page == 'aprendices' && in_array($_SESSION['user']['role'], ['admin', 'instructor'])): ?>
                <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                    <form method="POST" action="?page=aprendices&action=crear_aprendiz" class="flex gap-2 mb-4">
                        <input name="nombre" placeholder="Nombre" class="border p-1" required>
                        <input name="prog" placeholder="Programa" class="border p-1">
                        <button class="bg-blue-600 text-white px-2">+</button>
                    </form>
                <?php endif; ?>
                <table class="w-full bg-white shadow">
                    <?php foreach ($db->query("SELECT * FROM aprendices") as $a): ?>
                        <tr>
                            <td class="p-2"><?= htmlspecialchars($a['nombre']) ?></td>
                            <td class="p-2"><?= htmlspecialchars($a['programa']) ?></td>
                            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                <td><a href="?page=aprendices&action=del&tabla=aprendices&id=<?= $a['id'] ?>"
                                        class="text-red-500">Eliminar</a></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>

            <?php if ($page == 'instructores' && $_SESSION['user']['role'] == 'admin'): ?>
                <div class="bg-white p-4 shadow rounded mb-4">
                    <h2 class="font-bold mb-3">Crear Instructor</h2>
                    <form method="POST" action="?page=instructores&action=crear_instructor" class="grid grid-cols-3 gap-2">
                        <input name="nombre" placeholder="Nombre" class="border p-2" required>
                        <input name="esp" placeholder="Especialidad" class="border p-2">
                        <button class="col-span-3 bg-blue-600 text-white p-2">Agregar instructor</button>
                    </form>
                </div>
                <div class="bg-white p-4 shadow rounded">
                    <h2 class="font-bold mb-3">Listado de instructores</h2>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="p-2 border">Nombre</th>
                                <th class="p-2 border">Especialidad</th>
                                <th class="p-2 border">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($db->query("SELECT * FROM instructores") as $i): ?>
                                <tr>
                                    <td class="p-2 border"><?= htmlspecialchars($i['nombre']) ?></td>
                                    <td class="p-2 border"><?= htmlspecialchars($i['especialidad']) ?></td>
                                    <td class="p-2 border"><a
                                            href="?page=instructores&action=del&tabla=instructores&id=<?= $i['id'] ?>"
                                            class="text-red-500">Eliminar</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if ($page == 'auditoria' && $_SESSION['user']['role'] == 'admin'): ?>
                <div class="bg-white p-4 shadow rounded">
                    <h2 class="font-bold mb-3">Registro de Auditoría</h2>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="p-2 border">Fecha</th>
                                <th class="p-2 border">Usuario</th>
                                <th class="p-2 border">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($db->query("SELECT * FROM auditoria ORDER BY fecha DESC LIMIT 100") as $log): ?>
                                <tr>
                                    <td class="p-2 border"><?= htmlspecialchars($log['fecha']) ?></td>
                                    <td class="p-2 border"><?= htmlspecialchars($log['usuario']) ?></td>
                                    <td class="p-2 border"><?= htmlspecialchars($log['accion']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if ($page == 'riesgos'): ?>
                <?php $editRisk = null;
                if (isset($_GET['edit']) && $_SESSION['user']['role'] === 'admin') {
                    $stmt = $db->prepare('SELECT * FROM riesgos WHERE id = ?');
                    $stmt->execute([$_GET['edit']]);
                    $editRisk = $stmt->fetch();
                }
                ?>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <form method="POST" action="?page=riesgos&action=<?= $editRisk ? 'editar_riesgo' : 'crear_riesgo' ?>"
                        class="grid grid-cols-2 gap-2 bg-white p-4 shadow mb-4">
                        <input name="desc" placeholder="Descripción" class="col-span-2 border p-2" required
                            value="<?= $editRisk ? htmlspecialchars($editRisk['descripcion']) : '' ?>">
                        <input type="number" name="prob" placeholder="Prob (1-3)" class="border p-2" min="1" max="3" required
                            value="<?= $editRisk ? max(1, min(3, ceil($editRisk['nivel'] / 2))) : '' ?>">
                        <input type="number" name="imp" placeholder="Imp (1-3)" class="border p-2" min="1" max="3" required
                            value="<?= $editRisk ? max(1, min(3, ceil($editRisk['nivel'] / 2))) : '' ?>">
                        <textarea name="just" placeholder="Justificación" class="col-span-2 border p-2"
                            required><?= $editRisk ? htmlspecialchars($editRisk['justificacion']) : '' ?></textarea>
                        <?php if ($editRisk): ?><input type="hidden" name="id" value="<?= $editRisk['id'] ?>"><?php endif; ?>
                        <button
                            class="col-span-2 bg-red-600 text-white p-2"><?= $editRisk ? 'Actualizar riesgo' : 'Guardar riesgo' ?></button>
                    </form>
                <?php endif; ?>
                <div class="bg-white p-4 shadow rounded">
                    <h2 class="font-bold mb-3">Listado de riesgos</h2>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="p-2 border">Descripción</th>
                                <th class="p-2 border">Nivel</th>
                                <th class="p-2 border">Justificación</th><?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                    <th class="p-2 border">Acciones</th><?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($db->query("SELECT * FROM riesgos") as $r): ?>
                                <?php $color = ($r['nivel'] >= 6) ? 'text-red-700' : (($r['nivel'] >= 3) ? 'text-yellow-700' : 'text-green-700'); ?>
                                <tr>
                                    <td class="p-2 border"><?= htmlspecialchars($r['descripcion']) ?></td>
                                    <td class="p-2 border <?= $color ?>"><?= $r['nivel'] ?></td>
                                    <td class="p-2 border"><?= htmlspecialchars($r['justificacion']) ?></td>
                                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                        <td class="p-2 border flex gap-2">
                                            <a href="?page=riesgos&edit=<?= $r['id'] ?>" class="text-blue-500">Editar</a>
                                            <a href="?page=riesgos&action=del&tabla=riesgos&id=<?= $r['id'] ?>"
                                                class="text-red-500">Eliminar</a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if ($page == 'observaciones'): ?>
                <?php if ($_SESSION['user']['role'] === 'instructor'): ?>
                    <div class="bg-white p-4 shadow rounded mb-4">
                        <h2 class="font-bold mb-3">Registrar observación</h2>
                        <form method="POST" action="?page=observaciones&action=crear_observacion" class="grid grid-cols-1 gap-2">
                            <select name="aprendiz_id" class="border p-2" required>
                                <option value="">Seleccionar aprendiz</option>
                                <?php foreach ($db->query("SELECT id, nombre FROM aprendices") as $a): ?>
                                    <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <textarea name="texto" placeholder="Observación" class="border p-2" rows="4" required></textarea>
                            <button class="bg-blue-600 text-white p-2">Guardar observación</button>
                        </form>
                    </div>
                <?php endif; ?>
                <div class="bg-white p-4 shadow rounded">
                    <h2 class="font-bold mb-3">Observaciones</h2>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="p-2 border">Aprendiz</th>
                                <th class="p-2 border">Observación</th>
                                <th class="p-2 border">Autor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT o.*, a.nombre AS aprendiz_nombre, u.username AS autor_nombre FROM observaciones o LEFT JOIN aprendices a ON o.aprendiz_id = a.id LEFT JOIN usuarios u ON o.autor_id = u.id";
                            foreach ($db->query($sql) as $obs): ?>
                                <tr>
                                    <td class="p-2 border"><?= htmlspecialchars($obs['aprendiz_nombre'] ?? 'Desconocido') ?></td>
                                    <td class="p-2 border"><?= htmlspecialchars($obs['texto']) ?></td>
                                    <td class="p-2 border"><?= htmlspecialchars($obs['autor_nombre'] ?? 'Sistema') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </main>
    <?php endif; ?>
</body>

</html>