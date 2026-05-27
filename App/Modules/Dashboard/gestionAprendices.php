
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