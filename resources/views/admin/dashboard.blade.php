@extends('layouts.admin')

@section('title', 'Consola Central Ejecutiva — Broker Manager')
@section('page_title', 'Consola Central de Inteligencia y Control')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    
    {{-- Banner de Estado de Ciberseguridad --}}
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 border border-indigo-900/50 shadow-2xl relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-900/60 border border-indigo-700/50 text-[10px] font-bold text-indigo-300 font-mono uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>Broker Multi-Tenant Engine Online</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Supervisión Maestra del Ecosistema</h2>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed max-w-2xl">
                    Control centralizado de organizaciones federadas, zonas territoriales, convenios con aseguradoras y registro histórico de auditoría inmutable.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800 text-right">
                    <span class="block text-[10px] uppercase font-mono text-slate-500 font-bold">Base de Datos</span>
                    <span class="block text-sm font-bold text-emerald-400 font-mono">100% Sincronizada</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Métricas Principales (KPIs) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        {{-- KPI 1: Organizaciones --}}
        <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 space-y-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-mono">Organizaciones</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-white font-mono">{{ $stats['organizations_count'] }}</span>
                <span class="text-[11px] text-emerald-400 font-mono font-bold">Activas</span>
            </div>
        </div>

        {{-- KPI 2: Zonas --}}
        <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 space-y-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-mono">Zonas Comerciales</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-white font-mono">{{ $stats['zones_count'] }}</span>
                <span class="text-[11px] text-sky-400 font-mono font-bold">Jurisdicciones</span>
            </div>
        </div>

        {{-- KPI 3: Aseguradoras --}}
        <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 space-y-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-mono">Aseguradoras</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-white font-mono">{{ $stats['insurers_count'] }}</span>
                <span class="text-[11px] text-indigo-400 font-mono font-bold">Con Convenio</span>
            </div>
        </div>

        {{-- KPI 4: Matrículas PAS --}}
        <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 space-y-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-mono">Matrículas PAS</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-white font-mono">{{ $stats['pas_count'] }}</span>
                <span class="text-[11px] text-amber-400 font-mono font-bold">SSN Oficial</span>
            </div>
        </div>

        {{-- KPI 5: Usuarios Totales --}}
        <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 space-y-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-mono">Usuarios del Broker</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-white font-mono">{{ $stats['users_count'] }}</span>
                <span class="text-[11px] text-slate-400 font-mono font-bold">Registrados</span>
            </div>
        </div>
    </div>

    {{-- Grid 2 Columnas: Organizaciones y Registro de Auditoría --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Columna 1: Organizaciones & Red Operativa --}}
        <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 space-y-5" id="organizaciones">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <h3 class="text-base font-bold text-white tracking-tight flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Red de Organizaciones Operativas</span>
                </h3>
                <span class="text-[10px] text-slate-500 font-mono uppercase">Matriz Multi-Broker</span>
            </div>

            <div class="space-y-3">
                @foreach ($organizations as $org)
                    <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800/80 hover:border-slate-700 transition-colors space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-sm text-white">{{ $org->name }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-slate-800 text-sky-400 border border-slate-700">
                                {{ $org->code }}
                            </span>
                        </div>
                        <div class="text-xs text-slate-400 space-y-0.5 font-mono">
                            <p><span class="text-slate-500">CUIT:</span> {{ $org->cuit }} &bull; <span class="text-slate-500">Legal:</span> {{ $org->legal_name }}</p>
                            <p><span class="text-slate-500">Zonas Asignadas:</span> {{ $org->zones->count() }} jurisdicción(es)</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Columna 2: Registro de Auditoría (Audit Log) --}}
        <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 space-y-5" id="auditoria">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <h3 class="text-base font-bold text-white tracking-tight flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Registro de Auditoría &amp; Trazabilidad</span>
                </h3>
                <span class="text-[10px] text-slate-500 font-mono uppercase">Seguridad Inmutable</span>
            </div>

            @if ($recentAudits->isEmpty())
                <div class="p-8 rounded-2xl bg-slate-950/40 border border-slate-800/60 text-center text-slate-500 text-xs font-mono">
                    <p>No hay eventos de auditoría anómalos o recientes.</p>
                    <p class="text-[11px] text-slate-600 mt-1">El motor de auditoría filtra automáticamente las acciones de usuarios GOD.</p>
                </div>
            @else
                <div class="space-y-2.5">
                    @foreach ($recentAudits as $audit)
                        <div class="p-3 rounded-xl bg-slate-950/60 border border-slate-800 text-xs font-mono space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-indigo-400">{{ $audit->action }}</span>
                                <span class="text-[10px] text-slate-500">{{ $audit->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-slate-400 text-[11px]">{{ $audit->description }}</p>
                            <p class="text-[10px] text-slate-600">IP: {{ $audit->ip_address }} &bull; Usuario #{{ $audit->user_id }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
