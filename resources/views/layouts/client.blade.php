<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Portal del Asegurado — Broker Manager')</title>

    {{-- Tipografía Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-800 flex overflow-hidden">

    {{-- SIDEBAR LATERAL PARA CLIENTE / ASEGURADO --}}
    <aside id="client-sidebar" class="w-72 bg-white border-r border-slate-200/80 flex flex-col shrink-0 z-30 transition-transform duration-300 md:translate-x-0 -translate-x-full fixed md:static inset-y-0 left-0">
        {{-- Brand Header --}}
        <div class="h-16 px-6 flex items-center justify-between border-b border-slate-100">
            <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-600 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-sky-600/20 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <span class="block font-extrabold text-base tracking-tight text-slate-900 leading-tight">Broker Manager</span>
                    <span class="block text-[11px] font-semibold text-sky-600 uppercase tracking-wider">Portal Asegurado</span>
                </div>
            </a>
            <button type="button" class="md:hidden text-slate-400 hover:text-slate-600" onclick="toggleSidebar()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Badge de Asegurado --}}
        <div class="p-4 mx-4 mt-4 rounded-2xl bg-sky-50 border border-sky-100 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-sky-600 text-white font-bold flex items-center justify-center text-sm shadow-sm shrink-0">
                {{ strtoupper(substr(Auth::user()->party->first_name ?? Auth::user()->username, 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-slate-900 truncate">
                    {{ Auth::user()->party->display_name ?? Auth::user()->username }}
                </p>
                <p class="text-[11px] text-sky-700 truncate font-mono">
                    {{ Auth::user()->email }}
                </p>
            </div>
        </div>

        {{-- Items de Navegación del Cliente --}}
        <nav class="flex-1 px-4 py-4 space-y-1.5 overflow-y-auto">
            <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                Gestión Personal
            </div>

            <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('portal.dashboard') ? 'bg-sky-600 text-white shadow-sm shadow-sky-600/30' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Mi Resumen</span>
            </a>

            <a href="#polizas" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Mis Pólizas Activas</span>
                <span class="ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">Al Día</span>
            </a>

            <a href="#pagos" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span>Pagos y Recibos</span>
            </a>

            <a href="#bienes" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Bienes Asegurados</span>
            </a>

            <a href="#cotizaciones" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>Mis Cotizaciones</span>
            </a>

            <div class="pt-4 px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                Asistencia y Soporte
            </div>

            <a href="#siniestros" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-rose-600 hover:bg-rose-50 transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Denunciar Siniestro</span>
            </a>

            <a href="#contacto" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Contacto con Asesor</span>
            </a>
        </nav>

        {{-- Footer de Usuario y Botón de Perfil / Logout --}}
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            <button 
                type="button" 
                onclick="openProfileModal()" 
                class="w-full flex items-center justify-between p-2.5 rounded-xl text-left hover:bg-white border border-transparent hover:border-slate-200 transition-colors text-slate-700"
            >
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-700 font-bold flex items-center justify-center text-xs">
                        {{ strtoupper(substr(Auth::user()->party->first_name ?? Auth::user()->username, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <span class="block text-xs font-bold text-slate-900 truncate">Ver mi Perfil</span>
                        <span class="block text-[11px] text-slate-500">Ajustes &amp; Salir</span>
                    </div>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </aside>

    {{-- Overlay para móviles --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/40 z-20 hidden md:hidden" onclick="toggleSidebar()"></div>

    {{-- ÁREA DE CONTENIDO PRINCIPAL --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        {{-- Navbar Superior --}}
        <header class="h-16 bg-white border-b border-slate-200/80 px-4 sm:px-6 flex items-center justify-between shrink-0 sticky top-0 z-10">
            <div class="flex items-center gap-3">
                <button type="button" class="md:hidden text-slate-600 hover:text-slate-900 p-1.5 rounded-lg focus-ring" onclick="toggleSidebar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-base sm:text-lg font-bold text-slate-900">@yield('page_title', 'Bienvenido a tu Portal')</h1>
            </div>

            <div class="flex items-center gap-3">
                <span class="hidden sm:inline-flex items-center gap-1.5 text-xs text-emerald-700 bg-emerald-50 border border-emerald-200/80 px-2.5 py-1 rounded-full font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Sesión Única Activa
                </span>

                <button type="button" onclick="openProfileModal()" class="flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-sky-600 transition-colors p-1.5 rounded-xl hover:bg-slate-50">
                    <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-sky-600 to-indigo-600 text-white font-bold text-xs flex items-center justify-center">
                        {{ strtoupper(substr(Auth::user()->party->first_name ?? Auth::user()->username, 0, 1)) }}
                    </div>
                    <span class="hidden md:inline">{{ Auth::user()->party->first_name ?? Auth::user()->username }}</span>
                </button>
            </div>
        </header>

        {{-- Main Page Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    {{-- MODAL DE PERFIL Y CIERRE DE SESIÓN --}}
    <div id="profile-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-6 relative animate-in fade-in zoom-in-95 duration-150">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Mi Perfil de Asegurado</h3>
                <button type="button" onclick="closeProfileModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Información del Cliente --}}
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-sky-600 to-indigo-600 text-white text-xl font-bold flex items-center justify-center shadow-md shadow-sky-600/20">
                        {{ strtoupper(substr(Auth::user()->party->first_name ?? Auth::user()->username, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-base leading-snug">
                            {{ Auth::user()->party->display_name ?? Auth::user()->username }}
                        </h4>
                        <p class="text-xs text-slate-500 font-mono">{{ Auth::user()->email }}</p>
                        <span class="inline-block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-sky-100 text-sky-800">
                            Rol: Cliente Asegurado
                        </span>
                    </div>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 text-xs space-y-1.5 text-slate-600 font-mono">
                    <p><span class="text-slate-400">Usuario:</span> {{ Auth::user()->username }}</p>
                    <p><span class="text-slate-400">IP Actual:</span> {{ request()->ip() }}</p>
                    <p><span class="text-slate-400">Seguridad:</span> Sesión única por dispositivo (Device Session Activa)</p>
                </div>
            </div>

            {{-- Botón Cerrar Sesión con Confirmación --}}
            <div class="pt-2 border-t border-slate-100 flex items-center justify-between gap-3">
                <button type="button" onclick="closeProfileModal()" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Volver al Panel
                </button>

                <button 
                    type="button" 
                    onclick="confirmLogout()" 
                    class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-sm shadow-rose-600/30 transition-colors flex items-center gap-2 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Cerrar Sesión</span>
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL DE CONFIRMACIÓN DE CIERRE DE SESIÓN --}}
    <div id="logout-confirm-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 sm:p-7 shadow-2xl border border-slate-200 text-center space-y-4 relative animate-in fade-in zoom-in-95 duration-150">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <div class="space-y-1">
                <h3 class="text-lg font-bold text-slate-900">¿Cerrar Sesión?</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Se cerrará la sesión activa y se invalidará el dispositivo actual. Serás redirigido al portal de inicio de sesión.
                </p>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="pt-2 flex items-center justify-center gap-3">
                @csrf
                <button type="button" onclick="closeLogoutConfirm()" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-md shadow-rose-600/30 transition-colors cursor-pointer">
                    Sí, Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('client-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function openProfileModal() {
            document.getElementById('profile-modal').classList.remove('hidden');
        }

        function closeProfileModal() {
            document.getElementById('profile-modal').classList.add('hidden');
        }

        function confirmLogout() {
            closeProfileModal();
            document.getElementById('logout-confirm-modal').classList.remove('hidden');
        }

        function closeLogoutConfirm() {
            document.getElementById('logout-confirm-modal').classList.add('hidden');
        }
    </script>
</body>
</html>
