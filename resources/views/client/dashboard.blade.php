@extends('layouts.client')

@section('title', 'Mi Panel — Portal del Asegurado')
@section('page_title', 'Hola, ' . ($party->first_name ?? Auth::user()->username))

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    
    {{-- Banner de Bienvenida y Respaldo --}}
    <div class="rounded-3xl bg-gradient-to-r from-sky-600 via-indigo-600 to-slate-900 p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative z-10 max-w-2xl space-y-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold text-sky-100">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Cobertura Activa y Vigente
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Todas tus coberturas bajo control</h2>
            <p class="text-sm text-sky-100/90 leading-relaxed">
                Descargá tus certificados de circulación en cualquier momento, gestioná pagos online y accedé a tu historial completo sin moverte de tu casa.
            </p>
        </div>
    </div>

    {{-- Tarjetas KPI del Asegurado --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Card 1: Pólizas Activas --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
            <div class="flex items-center justify-between text-slate-500">
                <span class="text-xs font-bold uppercase tracking-wider">Pólizas Vigentes</span>
                <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div>
                <span class="text-2xl font-black text-slate-900">2</span>
                <span class="text-xs text-emerald-600 font-semibold ml-1">Automotor y Hogar</span>
            </div>
        </div>

        {{-- Card 2: Estado de Cobranza --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
            <div class="flex items-center justify-between text-slate-500">
                <span class="text-xs font-bold uppercase tracking-wider">Estado de Pagos</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div>
                <span class="text-2xl font-black text-emerald-600">Al Día</span>
                <span class="text-xs text-slate-500 font-medium ml-1">Sin deuda exigible</span>
            </div>
        </div>

        {{-- Card 3: Bienes Amparados --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
            <div class="flex items-center justify-between text-slate-500">
                <span class="text-xs font-bold uppercase tracking-wider">Bienes Registrados</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
            <div>
                <span class="text-2xl font-black text-slate-900">2</span>
                <span class="text-xs text-slate-500 font-medium ml-1">1 Vehículo &bull; 1 Inmueble</span>
            </div>
        </div>

        {{-- Card 4: Cotizaciones Pendientes --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
            <div class="flex items-center justify-between text-slate-500">
                <span class="text-xs font-bold uppercase tracking-wider">Cotizaciones</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <span class="text-2xl font-black text-slate-900">1</span>
                <span class="text-xs text-amber-600 font-semibold ml-1">Propuesta lista</span>
            </div>
        </div>
    </div>

    {{-- Tabla de Pólizas del Cliente (Placeholder de visualización elegante) --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden" id="polizas">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Mis Pólizas Activas</h3>
                <p class="text-xs text-slate-500">Listado de contratos de seguro vigentes y certificados digitales asociados.</p>
            </div>
            <a href="{{ route('home') }}#ramos" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-sky-600 bg-sky-50 hover:bg-sky-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>Cotizar Nueva Póliza</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Póliza / Ramo</th>
                        <th class="px-6 py-4">Aseguradora</th>
                        <th class="px-6 py-4">Bien Cubierto</th>
                        <th class="px-6 py-4">Vigencia</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-right">Certificado Digital</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">
                            <div>POL-2026-AUT-8812</div>
                            <span class="text-[11px] font-normal text-slate-500">Automotor &bull; Terceros Completo Premium</span>
                        </td>
                        <td class="px-6 py-4 text-slate-800 font-semibold">Rivadavia Seguros</td>
                        <td class="px-6 py-4 font-mono text-slate-700">Toyota Corolla Cross (AE 890 BC)</td>
                        <td class="px-6 py-4 text-slate-600">01/01/2026 al 31/12/2026</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Vigente
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition-colors">
                                <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Descargar PDF</span>
                            </button>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">
                            <div>POL-2026-HOG-1044</div>
                            <span class="text-[11px] font-normal text-slate-500">Hogar &bull; Combinado Familiar Integral</span>
                        </td>
                        <td class="px-6 py-4 text-slate-800 font-semibold">Finisterre Seguros</td>
                        <td class="px-6 py-4 text-slate-700">Inmueble Residencial (Bv. Oroño 1245)</td>
                        <td class="px-6 py-4 text-slate-600">15/02/2026 al 15/02/2027</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Vigente
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition-colors">
                                <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Descargar PDF</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Accesos Rápidos para Siniestros y Asistencia --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5" id="siniestros">
        <div class="p-6 rounded-3xl bg-rose-50 border border-rose-100 space-y-3">
            <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h4 class="text-base font-bold text-rose-950">¿Tuviste un siniestro o choque?</h4>
            <p class="text-xs text-rose-800 leading-relaxed">
                Efectuá la denuncia administrativa dentro de las 72 horas para que nuestro equipo pericial y legal tome tu caso ante la aseguradora de inmediato.
            </p>
            <button type="button" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 transition-colors shadow-sm shadow-rose-600/30">
                Iniciar Denuncia Online
            </button>
        </div>

        <div class="p-6 rounded-3xl bg-sky-50 border border-sky-100 space-y-3" id="contacto">
            <div class="w-10 h-10 rounded-xl bg-sky-600 text-white flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
            </div>
            <h4 class="text-base font-bold text-sky-950">Asistencia Mecánica y Remolque 24/7</h4>
            <p class="text-xs text-sky-800 leading-relaxed">
                Contactá a la central de urgencias de tu aseguradora o comunicate directamente con la sucursal de tu asesor asignado.
            </p>
            <a href="tel:08005550198" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 transition-colors shadow-sm shadow-sky-600/30">
                Llamar a Urgencias (0800-555-0198)
            </a>
        </div>
    </div>
</div>
@endsection
