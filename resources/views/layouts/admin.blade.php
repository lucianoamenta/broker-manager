<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Consola Ejecutiva de Seguridad — Broker Manager')</title>

    {{-- Tipografía Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-100 flex overflow-hidden bg-slate-950">

    {{-- SIDEBAR EJECUTIVO (ADMIN & GOD) --}}
    <aside id="admin-sidebar" class="w-72 bg-slate-900 border-r border-slate-800 flex flex-col shrink-0 z-30 transition-transform duration-300 md:translate-x-0 -translate-x-full fixed md:static inset-y-0 left-0">
        {{-- Brand Header --}}
        <div class="h-16 px-6 flex items-center justify-between border-b border-slate-800/80">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-sky-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/30 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <span class="block font-extrabold text-base tracking-tight text-white leading-tight">Broker Manager</span>
                    <span class="block text-[10px] font-bold text-sky-400 font-mono tracking-wider uppercase">Security &middot; Core Admin</span>
                </div>
            </a>
            <button type="button" class="md:hidden text-slate-400 hover:text-white" onclick="toggleAdminSidebar()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Badge de Nivel de Privilegios --}}
        <div class="p-3.5 mx-4 mt-4 rounded-2xl bg-slate-800/70 border border-slate-700/60 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ Auth::user()->hasRole(\App\Models\User::ROL_GOD) ? 'from-amber-500 to-rose-600' : 'from-indigo-600 to-sky-600' }} text-white font-bold flex items-center justify-center text-xs shadow-md shrink-0">
                {{ Auth::user()->hasRole(\App\Models\User::ROL_GOD) ? 'GOD' : 'ADM' }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-white truncate">
                    {{ Auth::user()->employee ? Auth::user()->employee->names . ' ' . Auth::user()->employee->surnames : Auth::user()->username }}
                </p>
                <p class="text-[11px] text-sky-400 truncate font-mono">
                    {{ Auth::user()->hasRole(\App\Models\User::ROL_GOD) ? 'Superadmin God Access' : 'Administrador General' }}
                </p>
            </div>
        </div>

        {{-- Navegación Ejecutiva --}}
        <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
            <div class="px-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-widest font-mono">
                Consola Central
            </div>

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard Ejecutivo</span>
            </a>

            <div class="pt-4 px-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-widest font-mono">
                Estructura Organizacional
            </div>

            <a href="#organizaciones" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span>Organizaciones &amp; Brokers</span>
            </a>

            <a href="#zonas" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                <span>Zonas Territoriales</span>
            </a>

            <div class="pt-4 px-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-widest font-mono">
                Aseguradoras &amp; PAS
            </div>

            <a href="#aseguradoras" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                </svg>
                <span>Compañías Aseguradoras</span>
            </a>

            <a href="#matriculas" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Matrículas PAS</span>
            </a>

            <div class="pt-4 px-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-widest font-mono">
                Seguridad &amp; Auditoría
            </div>

            <a href="#auditoria" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>Registro de Auditoría (Audit)</span>
            </a>

            <a href="#seguridad" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Usuarios, Roles &amp; Permisos</span>
            </a>
        </nav>

        {{-- Footer de Usuario y Botón de Perfil / Logout --}}
        <div class="p-4 border-t border-slate-800 bg-slate-950/40">
            <button 
                type="button" 
                onclick="openAdminProfileModal()" 
                class="w-full flex items-center justify-between p-2.5 rounded-xl text-left hover:bg-slate-800/80 border border-transparent hover:border-slate-700 transition-colors text-slate-300"
            >
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-indigo-950 text-indigo-400 font-bold flex items-center justify-center text-xs font-mono border border-indigo-800/40">
                        {{ strtoupper(substr(Auth::user()->username, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <span class="block text-xs font-bold text-white truncate">{{ Auth::user()->username }}</span>
                        <span class="block text-[10px] text-slate-400 font-mono">Consola Segura</span>
                    </div>
                </div>
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </aside>

    {{-- Overlay para móviles --}}
    <div id="admin-sidebar-overlay" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-20 hidden md:hidden" onclick="toggleAdminSidebar()"></div>

    {{-- ÁREA DE CONTENIDO PRINCIPAL --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-slate-950">
        {{-- Navbar Superior --}}
        <header class="h-16 bg-slate-900/90 backdrop-blur-md border-b border-slate-800 px-4 sm:px-6 flex items-center justify-between shrink-0 sticky top-0 z-10">
            <div class="flex items-center gap-3">
                <button type="button" class="md:hidden text-slate-400 hover:text-white p-1.5 rounded-lg" onclick="toggleAdminSidebar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-sm sm:text-base font-bold text-white font-mono flex items-center gap-2">
                    <span class="text-indigo-400">#</span>
                    <span>@yield('page_title', 'Consola Central Ejecutiva')</span>
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 text-xs text-indigo-300 bg-indigo-950/80 border border-indigo-800/60 px-2.5 py-1 rounded-full font-mono">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                    Terminal Encriptada
                </span>

                <button type="button" onclick="openAdminProfileModal()" class="flex items-center gap-2 text-xs font-semibold text-slate-300 hover:text-white p-1.5 rounded-xl hover:bg-slate-800 transition-colors">
                    <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-indigo-500 to-sky-500 text-white font-bold text-xs flex items-center justify-center font-mono">
                        {{ strtoupper(substr(Auth::user()->username, 0, 2)) }}
                    </div>
                    <span class="hidden md:inline">{{ Auth::user()->username }}</span>
                </button>
            </div>
        </header>

        {{-- Main Page Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    {{-- MODAL DE PERFIL ADMINISTRATIVO --}}
    <div id="admin-profile-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="bg-slate-900 rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-800 space-y-6 relative animate-in fade-in zoom-in-95 duration-150">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <h3 class="text-lg font-bold text-white tracking-tight flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Perfil de Operador Central</span>
                </h3>
                <button type="button" onclick="closeAdminProfileModal()" class="text-slate-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Información del Operador --}}
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-sky-600 text-white text-xl font-bold font-mono flex items-center justify-center shadow-lg shadow-indigo-600/30">
                        {{ strtoupper(substr(Auth::user()->username, 0, 2)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-base leading-snug">
                            {{ Auth::user()->employee ? Auth::user()->employee->names . ' ' . Auth::user()->employee->surnames : Auth::user()->username }}
                        </h4>
                        <p class="text-xs text-slate-400 font-mono">{{ Auth::user()->email }}</p>
                        <span class="inline-block mt-1 text-[10px] font-bold px-2.5 py-0.5 rounded-full {{ Auth::user()->hasRole(\App\Models\User::ROL_GOD) ? 'bg-amber-950 text-amber-300 border border-amber-800' : 'bg-indigo-950 text-indigo-300 border border-indigo-800' }}">
                            Roles: {{ Auth::user()->roles->pluck('name')->implode(', ') }}
                        </span>
                    </div>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-950/60 border border-slate-800 text-xs space-y-1.5 text-slate-400 font-mono">
                    <p><span class="text-slate-500">ID Usuario:</span> #{{ Auth::user()->id }} ({{ Auth::user()->uuid }})</p>
                    <p><span class="text-slate-500">IP de Conexión:</span> {{ request()->ip() }}</p>
                    <p><span class="text-slate-500">Sesión Device:</span> Monitoreada por DeviceSessionService</p>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="pt-2 border-t border-slate-800 flex items-center justify-between gap-3">
                <button type="button" onclick="closeAdminProfileModal()" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                    Cerrar Ventana
                </button>

                <button 
                    type="button" 
                    onclick="confirmAdminLogout()" 
                    class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-md shadow-rose-600/30 transition-colors flex items-center gap-2 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Cerrar Sesión</span>
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL DE CONFIRMACIÓN DE LOGOUT ADMINISTRATIVO --}}
    <div id="admin-logout-confirm-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="bg-slate-900 rounded-3xl max-w-sm w-full p-6 sm:p-7 shadow-2xl border border-slate-800 text-center space-y-4 relative animate-in fade-in zoom-in-95 duration-150">
            <div class="w-12 h-12 rounded-2xl bg-rose-950/80 border border-rose-800 text-rose-400 flex items-center justify-center mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <div class="space-y-1">
                <h3 class="text-base font-bold text-white">¿Desconectar Consola Administrativa?</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Se expulsará la sesión del dispositivo y retornarás a la pantalla de acceso de seguridad.
                </p>
            </div>

            <form action="{{ route('auth.admin.logout') }}" method="POST" class="pt-2 flex items-center justify-center gap-3">
                @csrf
                <button type="button" onclick="closeAdminLogoutConfirm()" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-semibold text-slate-300 bg-slate-800 hover:bg-slate-700 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-md shadow-rose-600/30 transition-colors cursor-pointer">
                    Confirmar Salida
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('admin-sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function openAdminProfileModal() {
            document.getElementById('admin-profile-modal').classList.remove('hidden');
        }

        function closeAdminProfileModal() {
            document.getElementById('admin-profile-modal').classList.add('hidden');
        }

        function confirmAdminLogout() {
            closeAdminProfileModal();
            document.getElementById('admin-logout-confirm-modal').classList.remove('hidden');
        }

        function closeAdminLogoutConfirm() {
            document.getElementById('admin-logout-confirm-modal').classList.add('hidden');
        }
    </script>
</body>
</html>
