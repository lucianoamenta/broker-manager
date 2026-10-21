<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Terminal Operativa de Red — Broker Manager')</title>

    {{-- Tipografía Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-800 flex overflow-hidden">

    {{-- SIDEBAR OPERATIVO ADAPTABLE --}}
    <aside id="console-sidebar" class="w-72 bg-white border-r border-slate-200 flex flex-col shrink-0 z-30 transition-transform duration-300 md:translate-x-0 -translate-x-full fixed md:static inset-y-0 left-0">
        {{-- Header de la Terminal --}}
        <div class="h-16 px-6 flex items-center justify-between border-b border-slate-100">
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-emerald-600 flex items-center justify-center text-white shadow-md shadow-emerald-600/20 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <span class="block font-extrabold text-base tracking-tight text-slate-900 leading-tight">Broker Manager</span>
                    <span class="block text-[10px] font-bold text-emerald-700 font-mono tracking-wider uppercase">Terminal Sucursal</span>
                </div>
            </a>
            <button type="button" class="md:hidden text-slate-400 hover:text-slate-600" onclick="toggleConsoleSidebar()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Badge de Rol Operativo --}}
        <div class="p-4 mx-4 mt-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-600 to-emerald-600 text-white font-bold flex items-center justify-center text-xs shadow-sm shrink-0 font-mono">
                {{ strtoupper(substr(Auth::user()->roles->first()?->name ?? 'OP', 0, 3)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-slate-900 truncate">
                    {{ Auth::user()->username }}
                </p>
                <p class="text-[11px] font-bold text-amber-800 truncate uppercase tracking-wider font-mono">
                    {{ str_replace('_', ' ', Auth::user()->roles->first()?->name ?? 'Operador') }}
                </p>
            </div>
        </div>

        {{-- Navegación Específica por Rol Operativo --}}
        <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">

            @if (Auth::user()->hasRole(\App\Models\User::ROL_CASHIER))
                {{-- MENU EXCLUSIVO PARA CAJEROS --}}
                <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest font-mono">
                    Operaciones de Caja
                </div>
                <a href="{{ route('console.cashier.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('console.cashier.dashboard') ? 'bg-amber-600 text-white shadow-sm shadow-amber-600/30' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Turno de Caja Activo</span>
                </a>
                <a href="#cobro" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span>Cobro de Póliza en Sucursal</span>
                </a>
                <a href="#recibos" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Emitir Recibo Oficial</span>
                </a>
                <a href="#arqueo" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span>Arqueo y Cierre de Turno</span>
                </a>

            @elseif (Auth::user()->hasRole(\App\Models\User::ROL_COLLECTOR))
                {{-- MENU EXCLUSIVO PARA RECAUDADORES --}}
                <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest font-mono">
                    Cobranza en Calle
                </div>
                <a href="{{ route('console.collector.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('console.collector.dashboard') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-600/30' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    <span>Mi Hoja de Ruta del Día</span>
                </a>
                <a href="#provisorio" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    <span>Emisión Recibo Provisorio</span>
                </a>
                <a href="#lote" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span>Lote de Cobranza Actual</span>
                </a>
                <a href="#rendicion" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    <span>Rendición a Tesorería</span>
                </a>

            @elseif (Auth::user()->hasRole(\App\Models\User::ROL_ADMIN_OFFICE))
                {{-- MENU PARA REPRESENTANTE DE OFICINA --}}
                <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest font-mono">
                    Sucursal Física
                </div>
                <a href="{{ route('console.office.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold bg-sky-600 text-white shadow-sm shadow-sky-600/30 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Panel de Oficina</span>
                </a>
                <a href="#cajas" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Cajas Registradoras</span>
                </a>
                <a href="#personal" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Cajeros de Sucursal</span>
                </a>

            @elseif (Auth::user()->hasRole(\App\Models\User::ROL_ADMIN_ZONE))
                {{-- MENU PARA REPRESENTANTE DE ZONA --}}
                <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest font-mono">
                    Jurisdicción Zonal
                </div>
                <a href="{{ route('console.zone.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold bg-indigo-600 text-white shadow-sm shadow-indigo-600/30 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    <span>Supervisión Zonal</span>
                </a>
                <a href="#oficinas" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Oficinas de la Zona</span>
                </a>
                <a href="#recaudadores" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Recaudadores de la Zona</span>
                </a>

            @elseif (Auth::user()->hasRole(\App\Models\User::ROL_ADMIN_ORGANIZATION))
                {{-- MENU PARA REPRESENTANTE DE ORGANIZACIÓN --}}
                <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest font-mono">
                    Comando de Broker
                </div>
                <a href="{{ route('console.organization.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold bg-emerald-600 text-white shadow-sm shadow-emerald-600/30 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                    <span>Panel de Organización</span>
                </a>
                <a href="#zonas" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    <span>Zonas Territoriales</span>
                </a>
                <a href="#aseguradoras" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Aseguradoras Habilitadas</span>
                </a>

            @else
                {{-- MENU GENÉRICO DEPARTAMENTAL --}}
                <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest font-mono">
                    Área Departamental
                </div>
                <a href="{{ route('console.department.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold bg-indigo-600 text-white shadow-sm shadow-indigo-600/30 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Gestión de Departamento</span>
                </a>
            @endif
        </nav>

        {{-- Footer de Usuario Operativo --}}
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            <button 
                type="button" 
                onclick="openConsoleProfileModal()" 
                class="w-full flex items-center justify-between p-2.5 rounded-xl text-left hover:bg-white border border-transparent hover:border-slate-200 transition-colors text-slate-700"
            >
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-800 font-bold flex items-center justify-center text-xs font-mono">
                        {{ strtoupper(substr(Auth::user()->username, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <span class="block text-xs font-bold text-slate-900 truncate">{{ Auth::user()->username }}</span>
                        <span class="block text-[10px] text-slate-500 font-mono">Terminal Activa</span>
                    </div>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </aside>

    {{-- Overlay para móviles --}}
    <div id="console-sidebar-overlay" class="fixed inset-0 bg-slate-900/40 z-20 hidden md:hidden" onclick="toggleConsoleSidebar()"></div>

    {{-- ÁREA DE CONTENIDO --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between shrink-0 sticky top-0 z-10">
            <div class="flex items-center gap-3">
                <button type="button" class="md:hidden text-slate-600 hover:text-slate-900 p-1.5 rounded-lg" onclick="toggleConsoleSidebar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-sm sm:text-base font-bold text-slate-900 font-mono">@yield('page_title', 'Terminal de Operaciones')</h1>
            </div>

            <div class="flex items-center gap-3">
                <span class="hidden sm:inline-flex items-center gap-1.5 text-xs text-amber-800 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-full font-mono">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Terminal En Línea
                </span>

                <button type="button" onclick="openConsoleProfileModal()" class="flex items-center gap-2 text-xs font-semibold text-slate-700 hover:text-amber-700 p-1.5 rounded-xl hover:bg-slate-50 transition-colors">
                    <div class="w-7 h-7 rounded-full bg-amber-600 text-white font-bold text-xs flex items-center justify-center font-mono">
                        {{ strtoupper(substr(Auth::user()->username, 0, 2)) }}
                    </div>
                    <span class="hidden md:inline">{{ Auth::user()->username }}</span>
                </button>
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    {{-- MODAL DE PERFIL OPERATIVO --}}
    <div id="console-profile-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-6 relative animate-in fade-in zoom-in-95 duration-150">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-900">Perfil de Terminal Operativa</h3>
                <button type="button" onclick="closeConsoleProfileModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-500 to-emerald-600 text-white text-xl font-bold font-mono flex items-center justify-center shadow-md">
                        {{ strtoupper(substr(Auth::user()->username, 0, 2)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-base leading-snug">
                            {{ Auth::user()->username }}
                        </h4>
                        <p class="text-xs text-slate-500 font-mono">{{ Auth::user()->email }}</p>
                        <span class="inline-block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 uppercase font-mono">
                            {{ str_replace('_', ' ', Auth::user()->roles->pluck('name')->implode(', ')) }}
                        </span>
                    </div>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 text-xs space-y-1.5 text-slate-600 font-mono">
                    <p><span class="text-slate-400">Terminal Node:</span> BM-{{ strtoupper(substr(md5(Auth::id()), 0, 8)) }}</p>
                    <p><span class="text-slate-400">Sesión Device:</span> Registrada en DeviceSessionService</p>
                    <p><span class="text-slate-400">IP Actual:</span> {{ request()->ip() }}</p>
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100 flex items-center justify-between gap-3">
                <button type="button" onclick="closeConsoleProfileModal()" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Cerrar
                </button>

                <button 
                    type="button" 
                    onclick="confirmConsoleLogout()" 
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

    {{-- MODAL DE CONFIRMACIÓN DE LOGOUT OPERATIVO --}}
    <div id="console-logout-confirm-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 sm:p-7 shadow-2xl border border-slate-200 text-center space-y-4 relative animate-in fade-in zoom-in-95 duration-150">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <div class="space-y-1">
                <h3 class="text-base font-bold text-slate-900">¿Cerrar Turno / Terminal?</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Tu sesión en este dispositivo será dada de baja. Si tienes arqueos pendientes, recuerda completarlos.
                </p>
            </div>

            <form action="{{ route('auth.console.logout') }}" method="POST" class="pt-2 flex items-center justify-center gap-3">
                @csrf
                <button type="button" onclick="closeConsoleLogoutConfirm()" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-md shadow-rose-600/30 transition-colors cursor-pointer">
                    Cerrar Terminal
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleConsoleSidebar() {
            const sidebar = document.getElementById('console-sidebar');
            const overlay = document.getElementById('console-sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function openConsoleProfileModal() {
            document.getElementById('console-profile-modal').classList.remove('hidden');
        }

        function closeConsoleProfileModal() {
            document.getElementById('console-profile-modal').classList.add('hidden');
        }

        function confirmConsoleLogout() {
            closeConsoleProfileModal();
            document.getElementById('console-logout-confirm-modal').classList.remove('hidden');
        }

        function closeConsoleLogoutConfirm() {
            document.getElementById('console-logout-confirm-modal').classList.add('hidden');
        }
    </script>
</body>
</html>
