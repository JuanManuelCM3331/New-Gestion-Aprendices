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
        <?php require_once __DIR__ . '/login.php'; ?>
        </div> <?php else: ?>
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
        <!--++++++++++++++++++++++++++ dashboard ++++++++++++++++++++++++++-->
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
                            class=" bg-<?= $color ?>-500 p-4 border-l-8 border-l-<?= $color ?>-600 rounded-r-full border-4 transition-all duration-300 hover:scale-150 shadow-xl text-white">
                            <p class="font-bold"><?= $r['descripcion'] ?></p>
                            <p class="text-xs text-white font-bold">Nivel: <?= $r['nivel'] ?></p>
                            <p class="text-xs text-white font-bold">Descripción: <?= $r['justificacion'] ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->


            <!--++++++++++++++++++++++++++ usuarios +++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <?php if ($page == 'usuarios' && $_SESSION['user']['role'] == 'admin'): ?>
                <?php require_once __DIR__ . '/gestionUsuarios.php'; ?>
            <?php endif; ?>
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

            <!--++++++++++++++++++++++++ aprendices +++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <?php if ($page == 'aprendices' && in_array($_SESSION['user']['role'], ['admin', 'instructor'])): ?>
                <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                    <?php require_once __DIR__ . '/gestionAprendices.php'; ?>
                <?php endif; ?>
            <?php endif; ?>
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

            <!--++++++++++++++++++++++++ instructores +++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <?php if ($page == 'instructores' && $_SESSION['user']['role'] == 'admin'): ?>
                <?php require_once __DIR__ . '/gestionInstructores.php'; ?>
            <?php endif; ?>
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

            <!--++++++++++++++++++++++++++ auditoria ++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <?php if ($page == 'auditoria' && $_SESSION['user']['role'] == 'admin'): ?>
                <?php require_once __DIR__ . '/auditoria.php'; ?>
            <?php endif; ?>
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

            <!--+++++++++++++++++++++++++++ riesgos +++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <?php if ($page == 'riesgos'): ?>
                <?php
                $editRisk = null;
                if (isset($_GET['edit']) && $_SESSION['user']['role'] === 'admin') {
                    $stmt = $db->prepare('SELECT * FROM riesgos WHERE id = ?');
                    $stmt->execute([$_GET['edit']]);
                    $editRisk = $stmt->fetch();
                }
                ?>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <?php require_once __DIR__ . '/gestionRiesgos.php'; ?>    
                <?php endif; ?>
            <?php endif; ?>
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

            <!--++++++++++++++++++++++++ Observaciones ++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <?php if ($page == 'observaciones'): ?>
                <!-- Formulario -->
                <?php if ($_SESSION['user']['role'] === 'instructor'): ?>
                    <?php require_once __DIR__ . '/observaciones.php'; ?>
                <?php endif; ?>
            <?php endif; ?>
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
        </main>
    <?php endif; ?>
</body>

</html>