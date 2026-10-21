@extends('layouts.console')

@section('title', 'Comando de Organización — Broker Manager')
@section('page_title', 'Dirección General de Broker')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-700 to-slate-900 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 space-y-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold text-emerald-100">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Estructura Organizacional Primaria
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Directorio de Organización</h2>
            <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed max-w-xl">
                Representante Institucional: <span class="font-bold text-white">{{ Auth::user()->username }}</span> &bull; Visión global de zonas territoriales, convenios de compañías de seguros y matrículas PAS.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Zonas Habilitadas</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">{{ $orgRep?->organization?->zones?->count() ?? 1 }}</span>
                <span class="text-xs text-emerald-700 font-bold">Activas</span>
            </div>
            <p class="text-[11px] text-slate-500">Jurisdicciones de comercialización.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Compañías de Seguros</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">3</span>
                <span class="text-xs text-teal-700 font-bold">Convenios</span>
            </div>
            <p class="text-[11px] text-slate-500">Federación Patronal, Sancor, San Cristóbal.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Matrículas PAS</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">2</span>
                <span class="text-xs text-slate-700 font-bold">Vigentes</span>
            </div>
            <p class="text-[11px] text-slate-500">Matrículas asignadas al broker.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Cartera Global</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">$ 850.000</span>
                <span class="text-xs text-emerald-700 font-bold">+12%</span>
            </div>
            <p class="text-[11px] text-slate-500">Prima emitida mensual consolidada.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 space-y-4">
        <h3 class="text-base font-bold text-slate-900">Zonas y Despliegue de la Organización</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-mono uppercase tracking-wider">
                        <th class="pb-3 font-semibold">Zona</th>
                        <th class="pb-3 font-semibold">Código</th>
                        <th class="pb-3 font-semibold">Oficinas</th>
                        <th class="pb-3 font-semibold text-right">Rendición</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    <tr>
                        <td class="py-3 font-semibold text-slate-900">Zona Capital / Gran Buenos Aires</td>
                        <td class="py-3 font-mono text-[11px]">ZONA-CENTRO</td>
                        <td class="py-3 font-mono">1 Sucursal Activa</td>
                        <td class="py-3 text-right">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Al Día</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
