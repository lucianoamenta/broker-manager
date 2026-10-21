@extends('layouts.app')

@section('title', 'Broker Manager — El Núcleo de Gestión de Seguros Definitivo')
@section('meta_description', 'Cotizaciones en tiempo real con las mejores aseguradoras, emisión ágil de pólizas, administración de cobranzas y atención personalizada.')

@section('content')
<div class="relative overflow-hidden">
    {{-- ========================================================================= --}}
    {{-- 1. HERO SECTION: Impacto visual, propuesta de valor y confianza --}}
    {{-- ========================================================================= --}}
    <section class="relative pt-12 pb-20 lg:pt-20 lg:pb-32 gradient-mesh">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                {{-- Columna Izquierda: Copywriting y Llamados a la Acción --}}
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-100/90 text-sky-800 border border-sky-300/60 text-xs font-semibold shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-sky-500 animate-ping"></span>
                        <span>Plataforma Multicompañía de Alto Rendimiento</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.15]">
                        La forma inteligente de <span class="gradient-text">proteger lo que más valorás</span>.
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto lg:mx-0 font-normal leading-relaxed">
                        Gestionamos, cotizamos y emitimos tus pólizas con las principales compañías aseguradoras del país. Claridad contractual, respaldo legal absoluto y atención humana en cada sucursal.
                    </p>

                    {{-- CTAs --}}
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="#coberturas" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl text-base font-semibold text-white gradient-brand shadow-lg shadow-sky-600/30 hover:shadow-xl hover:shadow-sky-600/40 hover:-translate-y-0.5 transition-all duration-200 focus-ring">
                            <span>Explorar Coberturas</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl text-base font-semibold text-slate-700 bg-white border border-slate-300/80 hover:bg-slate-50 hover:border-slate-400 transition-all duration-200 shadow-xs focus-ring">
                            <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Acceso Sistema</span>
                        </a>
                    </div>

                    {{-- Métricas de Confianza (Trust Signals) --}}
                    <div class="pt-8 grid grid-cols-3 gap-6 border-t border-slate-200/80 max-w-lg mx-auto lg:mx-0 text-left">
                        <div>
                            <span class="block text-2xl sm:text-3xl font-extrabold text-slate-900">+10</span>
                            <span class="text-xs sm:text-sm text-slate-500 font-medium">Aseguradoras Líderes</span>
                        </div>
                        <div>
                            <span class="block text-2xl sm:text-3xl font-extrabold text-slate-900">100%</span>
                            <span class="text-xs sm:text-sm text-slate-500 font-medium">Digital & Rápido</span>
                        </div>
                        <div>
                            <span class="block text-2xl sm:text-3xl font-extrabold text-slate-900">24/7</span>
                            <span class="text-xs sm:text-sm text-slate-500 font-medium">Asistencia Siniestros</span>
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha: Tarjeta Visual Interactiva / Mockup de Cobertura --}}
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        {{-- Glow de fondo --}}
                        <div class="absolute -inset-1.5 bg-gradient-to-r from-sky-400 to-emerald-400 rounded-3xl blur-xl opacity-30"></div>

                        {{-- Card Principal --}}
                        <div class="relative bg-white/95 rounded-2xl p-6 sm:p-8 shadow-xl border border-slate-200/80 backdrop-blur-md space-y-6">
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-slate-900">Certificado de Cobertura</h3>
                                        <p class="text-xs text-slate-500">Emisión inmediata y digital</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Vigente</span>
                            </div>

                            {{-- Puntos Clave en la Tarjeta --}}
                            <div class="space-y-3">
                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-slate-500">Ramo Seleccionado</span>
                                    <span class="font-semibold text-slate-800">Automotores / Todo Riesgo</span>
                                </div>
                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-slate-500">Suma Asegurada</span>
                                    <span class="font-semibold text-slate-800">$28.500.000 ARS</span>
                                </div>
                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-slate-500">Compañía Emisora</span>
                                    <span class="font-semibold text-sky-700">Aseguradora Calificada A+</span>
                                </div>
                            </div>

                            {{-- Respaldo Badge --}}
                            <div class="p-4 rounded-xl bg-sky-50/80 border border-sky-100 text-xs text-sky-900 flex items-start gap-3">
                                <svg class="w-5 h-5 text-sky-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <div>
                                    <span class="font-bold block text-sky-950">Garantía de Solidez Financiera</span>
                                    Todas las pólizas cuentan con registro oficial ante la SSN y cláusulas de amparo inalterables.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ========================================================================= --}}
    {{-- 2. PARTNERS / ASEGURADORAS: Marcas líderes con las que operamos --}}
    {{-- ========================================================================= --}}
    <section id="aseguradoras" class="py-16 bg-white border-y border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-12">
                <h2 class="text-xs font-bold text-sky-600 uppercase tracking-widest">Alianzas Comerciales Estratégicas</h2>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Trabajamos junto a las aseguradoras líderes del mercado</p>
                <p class="text-sm text-slate-500">Convenios directos que aseguran las mejores tarifas, condiciones de suscripción ágiles y máxima solvencia.</p>
            </div>

            {{-- Grilla de Logos / Aseguradoras con Tarjetas Estilizadas --}}
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center">
                {{-- Aseguradora 1: San Cristóbal --}}
                <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-slate-50 border border-slate-200/70 hover:border-sky-300 hover:shadow-md transition-all duration-200 group text-center">
                    <div class="w-12 h-12 rounded-xl bg-blue-100/80 text-blue-700 flex items-center justify-center font-bold text-lg mb-2 group-hover:scale-105 transition-transform">
                        SC
                    </div>
                    <span class="text-sm font-bold text-slate-800">San Cristóbal</span>
                    <span class="text-[11px] text-slate-400">Seguros Generales</span>
                </div>

                {{-- Aseguradora 2: La Segunda --}}
                <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-slate-50 border border-slate-200/70 hover:border-sky-300 hover:shadow-md transition-all duration-200 group text-center">
                    <div class="w-12 h-12 rounded-xl bg-red-100/80 text-red-700 flex items-center justify-center font-bold text-lg mb-2 group-hover:scale-105 transition-transform">
                        LS
                    </div>
                    <span class="text-sm font-bold text-slate-800">La Segunda</span>
                    <span class="text-[11px] text-slate-400">Seguros Patrimoniales</span>
                </div>

                {{-- Aseguradora 3: Sancor Seguros --}}
                <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-slate-50 border border-slate-200/70 hover:border-sky-300 hover:shadow-md transition-all duration-200 group text-center">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100/80 text-emerald-700 flex items-center justify-center font-bold text-lg mb-2 group-hover:scale-105 transition-transform">
                        SS
                    </div>
                    <span class="text-sm font-bold text-slate-800">Sancor Seguros</span>
                    <span class="text-[11px] text-slate-400">Grupo Asegurador</span>
                </div>

                {{-- Aseguradora 4: Federación Patronal --}}
                <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-slate-50 border border-slate-200/70 hover:border-sky-300 hover:shadow-md transition-all duration-200 group text-center">
                    <div class="w-12 h-12 rounded-xl bg-amber-100/80 text-amber-700 flex items-center justify-center font-bold text-lg mb-2 group-hover:scale-105 transition-transform">
                        FP
                    </div>
                    <span class="text-sm font-bold text-slate-800">Federación Pat.</span>
                    <span class="text-[11px] text-slate-400">Nº 1 en Producción</span>
                </div>

                {{-- Aseguradora 5: Rivadavia --}}
                <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-slate-50 border border-slate-200/70 hover:border-sky-300 hover:shadow-md transition-all duration-200 group text-center">
                    <div class="w-12 h-12 rounded-xl bg-indigo-100/80 text-indigo-700 flex items-center justify-center font-bold text-lg mb-2 group-hover:scale-105 transition-transform">
                        SR
                    </div>
                    <span class="text-sm font-bold text-slate-800">Seguros Rivadavia</span>
                    <span class="text-[11px] text-slate-400">Especialistas Automotor</span>
                </div>

                {{-- Aseguradora 6: Zurich Seguros --}}
                <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-slate-50 border border-slate-200/70 hover:border-sky-300 hover:shadow-md transition-all duration-200 group text-center">
                    <div class="w-12 h-12 rounded-xl bg-sky-100/80 text-sky-700 flex items-center justify-center font-bold text-lg mb-2 group-hover:scale-105 transition-transform">
                        ZH
                    </div>
                    <span class="text-sm font-bold text-slate-800">Zurich Argentina</span>
                    <span class="text-[11px] text-slate-400">Cobertura Internacional</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================================================= --}}
    {{-- 3. COBERTURAS Y RAMOS: Toda la gama aseguradora cubierta --}}
    {{-- ========================================================================= --}}
    <section id="coberturas" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <span class="text-xs font-bold text-sky-600 uppercase tracking-widest">Catálogo Multirriesgo</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Soluciones a la medida de tus necesidades</h2>
                <p class="text-base text-slate-600">Desde la protección de tu movilidad hasta contratos de caución complejos y amparo patrimonial.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Ramo 1: Automotores --}}
                <div class="bg-white rounded-2xl p-7 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-sky-200 transition-all duration-200 group flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white transition-colors duration-200">
                            {{-- Car SVG --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 11h16l-2-6H6l-2 6zm0 0v6h2m12 0h2v-6M4 11h16" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Seguros de Automotores</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Responsabilidad Civil, Terceros Completos, Granizo sin tope y Todo Riesgo con franquicia fija o variable. Asistencia en viaje 24/7.
                        </p>
                        <ul class="space-y-2 text-xs text-slate-500 pt-2">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> Reposición de 0km por robo o destrucción</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> Cobertura de cristales, cerraduras y ruedas</li>
                        </ul>
                    </div>
                </div>

                {{-- Ramo 2: Cauciones y Garantías --}}
                <div class="bg-white rounded-2xl p-7 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-sky-200 transition-all duration-200 group flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-200">
                            {{-- Document Check SVG --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Seguros de Caución</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Garantías para alquileres comerciales y residenciales, mantenimiento de oferta, ejecución de contrato de obra pública y fondos de reparo.
                        </p>
                        <ul class="space-y-2 text-xs text-slate-500 pt-2">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Calificación crediticia en 24 horas</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Pólizas electrónicas con firma digital SSN</li>
                        </ul>
                    </div>
                </div>

                {{-- Ramo 3: Hogar e Inmuebles --}}
                <div class="bg-white rounded-2xl p-7 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-sky-200 transition-all duration-200 group flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors duration-200">
                            {{-- Home SVG --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Hogar y Propiedades</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Protegé tu casa o departamento contra incendio de edificio y contenido, robo, daños por agua, electrodomésticos y responsabilidad civil privada.
                        </p>
                        <ul class="space-y-2 text-xs text-slate-500 pt-2">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Servicios de urgencia: plomería, gas y cerrajería</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Amparo de tecnología y notebooks en tránsito</li>
                        </ul>
                    </div>
                </div>

                {{-- Ramo 4: Vida y Accidentes Personales --}}
                <div class="bg-white rounded-2xl p-7 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-sky-200 transition-all duration-200 group flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition-colors duration-200">
                            {{-- Heart SVG --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Vida y Personas (AP)</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Accidentes personales (AP) con cláusula de no repetición para ingreso a obras y plantas industriales, seguros de vida individual y colectivo laboral.
                        </p>
                        <ul class="space-y-2 text-xs text-slate-500 pt-2">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Certificado de circulación laboral en el acto</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Gastos médicos y farmacéuticos amparados</li>
                        </ul>
                    </div>
                </div>

                {{-- Ramo 5: Integral de Comercio e Industria --}}
                <div class="bg-white rounded-2xl p-7 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-sky-200 transition-all duration-200 group flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-200">
                            {{-- Store SVG --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Comercios e Industrias</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Soluciones integrales para locales comerciales, depósitos y pymes: incendio de contenido, robo de mercadería, cristales, y responsabilidad civil operativa.
                        </p>
                        <ul class="space-y-2 text-xs text-slate-500 pt-2">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Respaldo ante cortes de cadena de frío</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Maquinaria y equipos electrónicos protegidos</li>
                        </ul>
                    </div>
                </div>

                {{-- Ramo 6: Responsabilidad Civil y Mala Praxis --}}
                <div class="bg-white rounded-2xl p-7 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-sky-200 transition-all duration-200 group flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-colors duration-200">
                            {{-- Scale / Balance SVG --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Responsabilidad Civil</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Amparo frente a reclamos de terceros por el ejercicio profesional (médicos, ingenieros, arquitectos) o la explotación de eventos masivos y actividades.
                        </p>
                        <ul class="space-y-2 text-xs text-slate-500 pt-2">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span> Cobertura de costas y defensa letrada</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span> Sumas acordes a las exigencias regulatorias</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================================================= --}}
    {{-- 4. CARACTERÍSTICAS / CÓMO GESTIONAMOS EL BROKER --}}
    {{-- ========================================================================= --}}
    <section id="caracteristicas" class="py-20 bg-white border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <span class="text-xs font-bold text-sky-600 uppercase tracking-widest">Tecnología & Excelencia Operativa</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Por qué administrar tus seguros con <span class="gradient-text">Broker Manager</span>
                    </h2>
                    <p class="text-slate-600 leading-relaxed">
                        Combinamos una plataforma web intuitiva con la calidez y el conocimiento de productores asesores matriculados distribuidos en sucursales de todo el país.
                    </p>

                    <div class="space-y-5 pt-2">
                        {{-- Beneficio 1 --}}
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center shrink-0 mt-1 font-bold">1</div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Cotizaciones Transparentes</h3>
                                <p class="text-sm text-slate-500">Desglose exacto de prima pura, impuestos y premio final sin costos ocultos.</p>
                            </div>
                        </div>

                        {{-- Beneficio 2 --}}
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-1 font-bold">2</div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Cobranza Omnicanal y Recibos Oficiales</h3>
                                <p class="text-sm text-slate-500">Pagos en sucursales con cajas registradoras auditadas, recaudadores en calle o medios digitales con comprobantes inmediatos.</p>
                            </div>
                        </div>

                        {{-- Beneficio 3 --}}
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0 mt-1 font-bold">3</div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Gestión Integral de Siniestros</h3>
                                <p class="text-sm text-slate-500">Acompañamiento personalizado desde la denuncia inicial hasta la liquidación de la indemnización.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Banner Ilustrativo de Gestión --}}
                <div class="relative">
                    <div class="p-8 rounded-3xl bg-slate-900 text-white shadow-2xl space-y-6 relative overflow-hidden">
                        {{-- Fondo decorativo abstracto --}}
                        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs uppercase tracking-wider text-sky-400 font-semibold">Trazabilidad en Tiempo Real</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                        </div>

                        <h3 class="text-2xl font-bold leading-snug">
                            "Un único sistema donde se unen clientes, productores y compañías."
                        </h3>

                        <div class="p-4 rounded-xl bg-slate-800/90 border border-slate-700/80 space-y-2 text-xs text-slate-300">
                            <div class="flex justify-between items-center text-slate-400">
                                <span>Estado de la Solicitud</span>
                                <span class="text-emerald-400 font-medium">Emitida</span>
                            </div>
                            <div class="w-full bg-slate-700 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full w-full rounded-full"></div>
                            </div>
                            <p class="text-[11px] text-slate-400 pt-1">Póliza asociada, comprobante oficial y endosos archivados de forma inmutable.</p>
                        </div>

                        <div class="flex items-center gap-3 pt-2 text-sm text-slate-300">
                            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Cumplimiento con resoluciones vigentes de la SSN</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================================================= --}}
    {{-- 5. PREGUNTAS FRECUENTES (FAQ con acordeón accesible) --}}
    {{-- ========================================================================= --}}
    <section id="faq" class="py-20 bg-slate-50 border-t border-slate-200/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-3 mb-16">
                <span class="text-xs font-bold text-sky-600 uppercase tracking-widest">Resolución de Dudas</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Preguntas Frecuentes</h2>
                <p class="text-base text-slate-600">Todo lo que necesitás saber sobre la contratación, validez y cobros de seguros.</p>
            </div>

            {{-- Lista de Preguntas / Acordeón --}}
            <div class="space-y-4" id="faq-accordion">
                {{-- FAQ 1 --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <button type="button" class="w-full px-6 py-5 text-left flex items-center justify-between text-base font-bold text-slate-900 hover:text-sky-600 transition-colors focus-ring" onclick="toggleFaq(1)" aria-expanded="true" aria-controls="faq-ans-1">
                        <span>¿Cuál es la diferencia entre Prima y Premio en una póliza?</span>
                        <svg id="faq-icon-1" class="w-5 h-5 text-slate-400 transform transition-transform duration-200 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq-ans-1" class="px-6 pb-6 text-sm text-slate-600 leading-relaxed">
                        La <strong>Prima</strong> (o prima pura) es el costo técnico del seguro que calcula la aseguradora en base al riesgo, y sobre ella se calculan las comisiones. El <strong>Premio</strong> es el monto final que paga el asegurado, el cual incluye la prima más los impuestos (IVA, sellados provinciales y tasas de la Superintendencia de Seguros). En Broker Manager siempre verás ambos conceptos claramente desglosados.
                    </div>
                </div>

                {{-- FAQ 2 --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <button type="button" class="w-full px-6 py-5 text-left flex items-center justify-between text-base font-bold text-slate-900 hover:text-sky-600 transition-colors focus-ring" onclick="toggleFaq(2)" aria-expanded="false" aria-controls="faq-ans-2">
                        <span>¿Qué validez tiene el certificado digital de cobertura?</span>
                        <svg id="faq-icon-2" class="w-5 h-5 text-slate-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq-ans-2" class="hidden px-6 pb-6 text-sm text-slate-600 leading-relaxed">
                        Posee <strong>validez legal absoluta</strong> ante cualquier autoridad policial, municipal, judicial o de control vial (Resolución SSN 219/2018). Podés exhibirlo en formato digital desde tu teléfono celular sin necesidad de llevarlo impreso en papel.
                    </div>
                </div>

                {{-- FAQ 3 --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <button type="button" class="w-full px-6 py-5 text-left flex items-center justify-between text-base font-bold text-slate-900 hover:text-sky-600 transition-colors focus-ring" onclick="toggleFaq(3)" aria-expanded="false" aria-controls="faq-ans-3">
                        <span>¿Cómo puedo abonar las cuotas de mi póliza?</span>
                        <svg id="faq-icon-3" class="w-5 h-5 text-slate-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq-ans-3" class="hidden px-6 pb-6 text-sm text-slate-600 leading-relaxed">
                        Ofrecemos múltiples canales: efectivo en sucursales físicas con emisión de recibo oficial numerado, recaudador de cobranza a domicilio con comprobante provisorio, transferencia bancaria y tarjeta de débito/crédito. Cada pago queda asentado de inmediato en el sistema.
                    </div>
                </div>

                {{-- FAQ 4 --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <button type="button" class="w-full px-6 py-5 text-left flex items-center justify-between text-base font-bold text-slate-900 hover:text-sky-600 transition-colors focus-ring" onclick="toggleFaq(4)" aria-expanded="false" aria-controls="faq-ans-4">
                        <span>¿Quiénes pueden acceder al sistema de gestión?</span>
                        <svg id="faq-icon-4" class="w-5 h-5 text-slate-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq-ans-4" class="hidden px-6 pb-6 text-sm text-slate-600 leading-relaxed">
                        El acceso al panel central está reservado para personal directivo, administradores de organizaciones, responsables de zona, operadores y cajeros autorizados mediante credenciales cifradas y roles estrictos.
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function toggleFaq(id) {
        const answer = document.getElementById(`faq-ans-${id}`);
        const icon = document.getElementById(`faq-icon-${id}`);
        const button = answer.previousElementSibling;

        if (answer.classList.contains('hidden')) {
            answer.classList.remove('hidden');
            icon.classList.add('rotate-180');
            button.setAttribute('aria-expanded', 'true');
        } else {
            answer.classList.add('hidden');
            icon.classList.remove('rotate-180');
            button.setAttribute('aria-expanded', 'false');
        }
    }
</script>
@endsection
