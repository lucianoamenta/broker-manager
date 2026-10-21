@extends('layouts.console')

@section('title', 'Comando Departamental — Broker Manager')
@section('page_title', 'Gestión de Departamento')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-800 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 space-y-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold text-slate-200">
                <span class="w-2 h-2 rounded-full bg-indigo-400"></span>
                Área Funcional
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Comando de Departamento</h2>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-xl">
                Responsable: <span class="font-bold text-white">{{ Auth::user()->username }}</span> &bull; Administración de tareas, expedientes y control de área corporativa.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Expedientes en Trámite</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">14</span>
                <span class="text-xs text-indigo-700 font-bold">En Revisión</span>
            </div>
            <p class="text-[11px] text-slate-500">Documentos asignados al equipo.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Tareas Pendientes</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">3</span>
                <span class="text-xs text-amber-700 font-bold">Prioridad Alta</span>
            </div>
            <p class="text-[11px] text-slate-500">Requerimientos con vencimiento próximo.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Estatus del Departamento</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-emerald-600 font-mono">Activo</span>
                <span class="text-xs text-emerald-700 font-bold">100% Operativo</span>
            </div>
            <p class="text-[11px] text-slate-500">Servicios y atención normalizados.</p>
        </div>
    </div>
</div>
@endsection
