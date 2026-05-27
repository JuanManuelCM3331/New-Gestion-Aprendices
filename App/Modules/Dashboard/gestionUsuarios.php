<div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-6 transition hover:shadow-md">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Crear Usuario</h2>
            <p class="text-sm text-slate-500">Registra nuevos usuarios en el sistema</p>
        </div>
    </div>
    <form method="POST" action="?page=usuarios&action=crear_usuario" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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