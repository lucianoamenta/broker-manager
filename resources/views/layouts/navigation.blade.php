<header class="sticky top-0 z-50 glass-panel border-b border-slate-200/80 transition-all duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            {{-- Brand Logo --}}
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group focus-ring rounded-lg p-1">
                    <div class="w-11 h-11 rounded-xl gradient-brand flex items-center justify-center text-white shadow-md shadow-sky-600/20 group-hover:scale-105 transition-transform duration-200">
                        {{-- Shield Icon --}}
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold tracking-tight text-slate-900 block leading-tight">Broker<span class="text-sky-600">Manager</span></span>
                        <span class="text-xs font-medium text-slate-500 uppercase tracking-wider block">Core Asegurador</span>
                    </div>
                </a>
            </div>

            {{-- Desktop Nav Links --}}
            <nav class="hidden md:flex items-center gap-8" aria-label="Navegación principal">
                <a href="{{ url('/') }}#coberturas" class="text-sm font-semibold text-slate-600 hover:text-sky-600 transition-colors focus-ring rounded px-2 py-1">Coberturas</a>
                <a href="{{ url('/') }}#aseguradoras" class="text-sm font-semibold text-slate-600 hover:text-sky-600 transition-colors focus-ring rounded px-2 py-1">Aseguradoras</a>
                <a href="{{ url('/') }}#caracteristicas" class="text-sm font-semibold text-slate-600 hover:text-sky-600 transition-colors focus-ring rounded px-2 py-1">Beneficios</a>
                <a href="{{ url('/') }}#faq" class="text-sm font-semibold text-slate-600 hover:text-sky-600 transition-colors focus-ring rounded px-2 py-1">Preguntas Frecuentes</a>
            </nav>

            {{-- Actions --}}
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-sky-700 bg-sky-50 border border-sky-200/80 hover:bg-sky-100 hover:border-sky-300 transition-all duration-150 shadow-sm focus-ring">
                    {{-- User Icon --}}
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Iniciar Sesión</span>
                </a>

                {{-- Mobile Menu Button --}}
                <button type="button" id="mobile-menu-toggle" aria-expanded="false" aria-controls="mobile-menu" class="md:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus-ring" aria-label="Abrir menú de navegación">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Drawer (Hidden by default) --}}
        <div id="mobile-menu" class="hidden md:hidden py-4 border-t border-slate-200/80 space-y-2">
            <a href="{{ url('/') }}#coberturas" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Coberturas</a>
            <a href="{{ url('/') }}#aseguradoras" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Aseguradoras</a>
            <a href="{{ url('/') }}#caracteristicas" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Beneficios</a>
            <a href="{{ url('/') }}#faq" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Preguntas Frecuentes</a>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu');
        if (toggleBtn && menu) {
            toggleBtn.addEventListener('click', function () {
                const isHidden = menu.classList.contains('hidden');
                menu.classList.toggle('hidden');
                toggleBtn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            });
        }
    });
</script>
