@extends('layouts.console')

@section('title', 'Terminal de Caja — Broker Manager')
@section('page_title', 'Terminal de Cobranzas en Sucursal (Caja)')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    
    {{-- Banner de Turno de Caja --}}
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-amber-600 to-emerald-700 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold text-amber-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                    Terminal de Caja Habilitada
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Cobro en Ventanilla &amp; Emisión de Recibos</h2>
                <p class="text-xs sm:text-sm text-amber-100/90 leading-relaxed max-w-xl">
                    Operador: <span class="font-bold text-white">{{ $cashier->full_name ?? Auth::user()->username }}</span> &bull; Sucursal: <span class="font-bold text-white">{{ $cashier->office->name ?? 'Sucursal Central' }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" class="px-4 py-2.5 rounded-xl bg-white text-slate-900 font-bold text-xs hover:bg-slate-50 transition-colors shadow-sm">
                    Abrir Turno de Caja
                </button>
            </div>
        </div>
    </div>

    {{-- Cajas Registradoras de la Sucursal --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Caja Física Sucursal</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">$ 0,00</span>
                <span class="text-xs text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full font-bold">Cerrada</span>
            </div>
            <p class="text-[11px] text-slate-500">Efectivo en gaveta para cobranzas físicas.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Caja Digital / Posnet</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">$ 0,00</span>
                <span class="text-xs text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full font-bold">Disponible</span>
            </div>
            <p class="text-[11px] text-slate-500">Cobros electrónicos, débito y transferencias.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Recibos Emitidos Hoy</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 font-mono">0</span>
                <span class="text-xs text-slate-500 font-medium">Comprobantes</span>
            </div>
            <p class="text-[11px] text-slate-500">Vouchers oficiales con firma y numeración legal.</p>
        </div>
    </div>

    {{-- Panel de Cobranza Rápida --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 space-y-4" id="cobro">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="text-base font-bold text-slate-900">Búsqueda Rápida de Póliza para Cobro</h3>
                <p class="text-xs text-slate-500">Ingresá el DNI/CUIT del tomador, número de póliza o patente del vehículo.</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <input 
                type="text" 
                placeholder="Buscar por DNI, CUIT, Número de Póliza o Patente..."
                class="flex-1 px-4 py-3 rounded-xl border border-slate-300 text-sm focus-ring bg-slate-50/50"
            >
            <button type="button" class="px-6 py-3 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition-colors">
                Buscar Cuotas Pendientes
            </button>
        </div>
    </div>
</div>
@endsection
