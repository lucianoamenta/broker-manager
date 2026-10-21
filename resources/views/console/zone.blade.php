@extends('layouts.console')

@section('title', 'Comando de Zona — Broker Manager')
@section('page_title', 'Supervisión y Control Zonal')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-indigo-700 via-indigo-600 to-sky-700 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 space-y-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold text-indigo-100">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Jurisdicción Territorial Activa
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Supervisión Territorial de Zona</h2>
            <p class="text-xs sm:text-sm text-indigo-100/90 leading-relaxed max-w-xl">
                Representante: <span class="font-bold text-white">{{ Auth::user()->username }}</span> &bull; Coordinación de oficinas, sucursales y fuerza de recaudación zonal.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Oficinas en la Zona</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">{{ $zoneRep?->zone?->offices?->count() ?? 1 }}</span>
                <span class="text-xs text-indigo-700 font-bold">Operativas</span>
            </div>
            <p class="text-[11px] text-slate-500">Sucursales físicas activas bajo supervisión.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Fuerza de Cobranza</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">1</span>
                <span class="text-xs text-emerald-700 font-bold">Asignado</span>
            </div>
            <p class="text-[11px] text-slate-500">Recaudadores territoriales habilitados.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Efectividad de Cobro</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">100%</span>
                <span class="text-xs text-emerald-700 font-bold">Normal</span>
            </div>
            <p class="text-[11px] text-slate-500">Ratio de rendiciones en término del período.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 space-y-4">
        <h3 class="text-base font-bold text-slate-900">Sucursales y Oficinas de la Jurisdicción</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-mono uppercase tracking-wider">
                        <th class="pb-3 font-semibold">Oficina</th>
                        <th class="pb-3 font-semibold">Dirección</th>
                        <th class="pb-3 font-semibold">Cajas</th>
                        <th class="pb-3 font-semibold text-right">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    <tr>
                        <td class="py-3 font-semibold text-slate-900">Sucursal Centro</td>
                        <td class="py-3 font-mono text-[11px]">San Martín 450, Centro</td>
                        <td class="py-3 font-mono">2 Cajas</td>
                        <td class="py-3 text-right">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Abierta</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
