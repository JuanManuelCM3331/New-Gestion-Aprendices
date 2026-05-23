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