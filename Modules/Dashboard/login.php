<div class="min-h-screen w-full flex items-center justify-center bg-slate-100 px-4 relative overflow-hidden">
    <!-- Fondo decorativo -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-200/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-slate-300/30 rounded-full blur-3xl"></div>
    </div> <!-- Login -->
    <div
        class="relative z-10 w-full max-w-md bg-white/90 backdrop-blur-sm border border-slate-200 rounded-3xl shadow-2xl p-8 transition duration-300 hover:shadow-blue-100">
        <!-- Header -->
        <div class="text-center mb-8">
            <div
                class="mx-auto mb-4 w-16 h-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-2xl font-bold shadow-lg">
            </div>
            <h2 class="text-3xl font-bold text-slate-800"> SGA Login </h2>
            <p class="text-slate-500 mt-2 text-sm"> Sistema de Gestión Académica </p>
        </div> <!-- Error --> <?php if (!empty($loginError)): ?>
            <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                <?= htmlspecialchars($loginError) ?>
            </div> <?php endif; ?> <!-- Formulario -->
        <form method="POST" action="?action=login" class="space-y-5">
            <div> <label class="block text-sm font-medium text-slate-600 mb-1"> Usuario </label> <input name="user"
                    placeholder="Ingresa tu usuario" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-blue-400 hover:bg-white">
            </div>
            <div> <label class="block text-sm font-medium text-slate-600 mb-1"> Contraseña </label> <input name="pass"
                    type="password" placeholder="Ingresa tu contraseña" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-slate-50 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-blue-400 hover:bg-white">
            </div> <button
                class="w-full py-3 rounded-xl bg-slate-900 text-white font-semibold tracking-wide transition duration-300 hover:bg-blue-600 hover:shadow-lg hover:-translate-y-0.5">
                Entrar al sistema </button>
        </form> <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-xs text-slate-400"> Plataforma administrativa · SGA </p>
        </div>
    </div>