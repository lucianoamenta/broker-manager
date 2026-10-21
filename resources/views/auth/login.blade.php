@extends('layouts.app')

@section('title', 'Iniciar Sesión — Portal Administrativo Broker Manager')
@section('meta_description', 'Acceso exclusivo al sistema para usuarios con roles administrativos y de control.')

@section('content')
<div class="min-h-[calc(100vh-14rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 gradient-mesh">
    <div class="max-w-md w-full space-y-8 bg-white/95 backdrop-blur-md p-8 sm:p-10 rounded-3xl shadow-xl border border-slate-200/80 relative">
        
        {{-- Header del Formulario --}}
        <div class="text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl gradient-brand flex items-center justify-center text-white mx-auto shadow-md shadow-sky-600/30">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Acceso al Panel Central</h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Exclusivo para usuarios con privilegios <span class="font-semibold text-sky-700">Administrador / GOD</span>.
            </p>
        </div>

        {{-- Alerta informativa de alcance de rol --}}
        <div class="p-3.5 rounded-xl bg-sky-50 border border-sky-100 text-xs text-sky-900 flex items-start gap-2.5">
            <svg class="w-4 h-4 text-sky-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>
                Este acceso está restringido a cuentas con rol <strong>admin</strong> o <strong>god</strong>. Si sos asesor comercial o cajero, utilizá tu terminal asignada en sucursal.
            </p>
        </div>

        {{-- Formulario de Login --}}
        <form class="mt-6 space-y-5" action="{{ route('login') }}" method="POST" id="login-form">
            @csrf

            {{-- Campo Identificador / Email o Username --}}
            <div class="space-y-1.5">
                <label for="login" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Correo Electrónico o Usuario
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input 
                        id="login" 
                        name="login" 
                        type="text" 
                        autocomplete="username" 
                        required 
                        placeholder="admin@broker.com o usuario"
                        class="block w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 text-slate-900 placeholder-slate-400 text-sm focus-ring bg-slate-50/50 hover:bg-white transition-colors"
                    >
                </div>
            </div>

            {{-- Campo Contraseña --}}
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Contraseña de Seguridad
                    </label>
                    <a href="#" class="text-xs font-semibold text-sky-600 hover:text-sky-700 transition-colors">¿Olvidaste tu clave?</a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        autocomplete="current-password" 
                        required 
                        placeholder="••••••••••••"
                        class="block w-full pl-11 pr-11 py-3 rounded-xl border border-slate-300 text-slate-900 placeholder-slate-400 text-sm focus-ring bg-slate-50/50 hover:bg-white transition-colors"
                    >
                    {{-- Toggle Ver Contraseña --}}
                    <button 
                        type="button" 
                        id="toggle-password" 
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus-ring rounded"
                        aria-label="Mostrar u ocultar contraseña"
                    >
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Recordar Sesión --}}
            <div class="flex items-center justify-between text-xs sm:text-sm">
                <label class="flex items-center gap-2.5 text-slate-600 select-none cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                    <span>Recordar sesión en este equipo</span>
                </label>
            </div>

            {{-- Botón de Ingreso --}}
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl text-sm font-bold text-white gradient-brand shadow-lg shadow-sky-600/30 hover:shadow-xl hover:shadow-sky-600/40 hover:-translate-y-0.5 transition-all duration-200 focus-ring cursor-pointer"
                >
                    <span>Ingresar al Sistema</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>

        {{-- Volver a la Landing --}}
        <div class="text-center pt-2">
            <a href="{{ url('/') }}" class="text-xs font-semibold text-slate-500 hover:text-sky-600 transition-colors inline-flex items-center gap-1.5 focus-ring rounded p-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Volver al portal principal</span>
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggle-password');
        const passInput = document.getElementById('password');
        
        if (toggleBtn && passInput) {
            toggleBtn.addEventListener('click', function() {
                const isPassword = passInput.getAttribute('type') === 'password';
                passInput.setAttribute('type', isPassword ? 'text' : 'password');
            });
        }
    });
</script>
@endsection
