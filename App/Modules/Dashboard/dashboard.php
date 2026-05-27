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
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
    <?php foreach ($db->query("SELECT * FROM riesgos") as $index => $r):
        $color = ($r['nivel'] >= 6) ? 'red' : (($r['nivel'] >= 3) ? 'yellow' : 'green');
    ?>
        <!-- Tarjeta -->
        <div class="flex flex-col bg-<?= $color ?>-100 p-5 border-l-8 border-<?= $color ?>-500 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 hover:scale-105">
            <h3 class="font-bold text-lg text-gray-800 mb-2"><?= htmlspecialchars($r['descripcion']) ?></h3>

            <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                <?= htmlspecialchars(substr($r['justificacion'], 0, 100)) ?>
            </p>

            <button onclick="document.getElementById('panel-<?= $index ?>').classList.remove('hidden')"
                    class="bg-<?= $color ?>-200 rounded-full mt-auto text-sm font-bold text-<?= $color ?>-600 hover:underline duration-300 hover:scale-110 cursor-pointer w-full py-4">
                Ver detalle completo →
            </button>
        </div>

        <!-- Overlay -->
        <div id="panel-<?= $index ?>"
             class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
             onclick="if(event.target===this) this.classList.add('hidden')">

            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg border border-<?= $color ?>-200">

                <!-- Header -->
                <div class="flex items-start justify-between gap-4 px-6 pt-6 pb-4 border-b border-<?= $color ?>-100 bg-<?= $color ?>-50 rounded-t-xl">
                    <h2 class="text-lg font-semibold leading-snug text-<?= $color ?>-900">
                        <?= htmlspecialchars($r['descripcion']) ?>
                    </h2>
                    <button onclick="document.getElementById('panel-<?= $index ?>').classList.add('hidden')"
                            class="shrink-0 mt-0.5 text-<?= $color ?>-400 hover:text-<?= $color ?>-700 transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="px-6 py-5 text-sm leading-relaxed text-gray-600">
                    <?= nl2br(htmlspecialchars($r['justificacion'])) ?>
                </div>

                <!-- Footer -->
                <div class="px-6 pb-6">
                    <button onclick="document.getElementById('panel-<?= $index ?>').classList.add('hidden')"
                            class="w-full py-2.5 rounded-lg text-sm font-medium transition-all cursor-pointer
                                   bg-<?= $color ?>-100 text-<?= $color ?>-800
                                   hover:bg-<?= $color ?>-200 active:scale-95">
                        Cerrar
                    </button>
                </div>

            </div>
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
                <?php if ($_SESSION['user']['role'] === 'instructor'|| $_SESSION['user']['role'] === 'admin'): ?>
                    <?php require_once __DIR__ . '/observaciones.php'; ?>
                <?php endif; ?>
            <?php endif; ?>
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
        </main>
    <?php endif; ?>
</body>

</html>