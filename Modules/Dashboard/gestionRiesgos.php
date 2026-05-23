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
