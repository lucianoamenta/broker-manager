@extends('layouts.console')

@section('title', 'Terminal de Recaudador — Broker Manager')
@section('page_title', 'Terminal Territorial de Cobranza en Calle')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    
    {{-- Banner de Recaudador --}}
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-600 to-slate-900 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold text-emerald-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                    Ruta de Cobranza Activa
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Cobranza en Domicilio &amp; Emisión Provisoria</h2>
                <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed max-w-xl">
                    Recaudador: <span class="font-bold text-white">{{ $collector->full_name ?? Auth::user()->username }}</span> &bull; Organización: <span class="font-bold text-white">{{ $collector->organization->name ?? 'Broker Central' }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" class="px-4 py-2.5 rounded-xl bg-white text-slate-900 font-bold text-xs hover:bg-slate-50 transition-colors shadow-sm">
                    Rendir Lote a Tesorería
                </button>
            </div>
        </div>
    </div>

    {{-- KPIs de Recaudación en Calle --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Total Recaudado en Mano</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">$ 0,00</span>
                <span class="text-xs text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full font-bold">Lote Abierto</span>
            </div>
            <p class="text-[11px] text-slate-500">Monto total en efectivo pendiente de rendición.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Recibos Provisorios Emitidos</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">0</span>
                <span class="text-xs text-slate-500 font-medium">Talonario Digital</span>
            </div>
            <p class="text-[11px] text-slate-500">Comprobantes provisorios entregados a asegurados.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Zonas Asignadas</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">{{ $collector->zones->count() ?? 1 }}</span>
                <span class="text-xs text-sky-700 bg-sky-50 px-2 py-0.5 rounded-full font-bold">Jurisdicción</span>
            </div>
            <p class="text-[11px] text-slate-500">
                {{ $collector->zones->first()?->name ?? 'Zona asignada por la organización' }}
            </p>
        </div>
    </div>

    {{-- Hoja de Ruta de Cobranza --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 space-y-4" id="ruta">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="text-base font-bold text-slate-900">Hoja de Ruta del Día</h3>
                <p class="text-xs text-slate-500">Listado de pólizas y domicilios programados para cobranza presencial.</p>
            </div>
        </div>

        <div class="p-8 text-center text-slate-400 text-xs font-mono bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
            </svg>
            <p>No hay visitas pendientes en la hoja de ruta para el día de hoy.</p>
            <p class="text-[11px] text-slate-500 mt-1">Los cobros se sincronizan automáticamente con la central de tesorería.</p>
        </div>
    </div>
</div>
@endsection
