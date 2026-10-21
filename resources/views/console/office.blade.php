@extends('layouts.console')

@section('title', 'Comando de Oficina — Broker Manager')
@section('page_title', 'Supervisión y Gestión de Sucursal')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-sky-600 to-indigo-700 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 space-y-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold text-sky-100">
                <span class="w-2 h-2 rounded-full bg-emerald-300"></span>
                Sucursal Operativa Habilitada
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Panel de Control de Oficina</h2>
            <p class="text-xs sm:text-sm text-sky-100/90 leading-relaxed max-w-xl">
                Encargado: <span class="font-bold text-white">{{ Auth::user()->username }}</span> &bull; Administración de Cajas, Cajeros y Rendiciones de Sucursal.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Cajas de la Oficina</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">2</span>
                <span class="text-xs text-sky-700 font-bold">1 Física &bull; 1 Virtual</span>
            </div>
            <p class="text-[11px] text-slate-500">Registradoras radicadas en el local.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Cajeros Asignados</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">1</span>
                <span class="text-xs text-emerald-700 font-bold">Habilitado</span>
            </div>
            <p class="text-[11px] text-slate-500">Operadores de ventanilla autorizados.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Rendiciones del Día</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">0</span>
                <span class="text-xs text-slate-500 font-medium">Al Día</span>
            </div>
            <p class="text-[11px] text-slate-500">Arqueos cerrados e informados a la central.</p>
        </div>
    </div>
</div>
@endsection
