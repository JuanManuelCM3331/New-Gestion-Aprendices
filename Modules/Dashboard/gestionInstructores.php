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