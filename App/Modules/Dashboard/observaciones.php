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