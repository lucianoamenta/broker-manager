<footer class="bg-slate-900 text-slate-300 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            {{-- Columna 1: Brand & Misión --}}
            <div class="space-y-4 md:col-span-1">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl gradient-brand flex items-center justify-center text-white shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-white">Broker<span class="text-sky-400">Manager</span></span>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Ecosistema tecnológico de gestión y emisión de pólizas para brokers, productores asesores y asegurados. Respaldado por las aseguradoras líderes del país.
                </p>
                <div class="pt-2 text-xs text-slate-500 flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Plataforma operativa 99.9% uptime</span>
                </div>
            </div>

            {{-- Columna 2: Coberturas --}}
            <div class="space-y-3">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Ramos Aseguradores</h3>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="#coberturas" class="hover:text-white transition-colors">Seguro Automotor y Flotas</a></li>
                    <li><a href="#coberturas" class="hover:text-white transition-colors">Hogar e Inmuebles</a></li>
                    <li><a href="#coberturas" class="hover:text-white transition-colors">Cauciones y Garantías</a></li>
                    <li><a href="#coberturas" class="hover:text-white transition-colors">Vida y Accidentes Personales</a></li>
                    <li><a href="#coberturas" class="hover:text-white transition-colors">Integral de Comercio</a></li>
                </ul>
            </div>

            {{-- Columna 3: Institucional & Soporte --}}
            <div class="space-y-3">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Plataforma</h3>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="{{ route('login') }}" class="hover:text-white transition-colors flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span> Acceso Exclusivo Staff</a></li>
                    <li><a href="#aseguradoras" class="hover:text-white transition-colors">Compañías Vinculadas</a></li>
                    <li><a href="#faq" class="hover:text-white transition-colors">Centro de Respuestas</a></li>
                    <li><a href="#terminos" onclick="openLegalModal('terms')" class="hover:text-white transition-colors">Términos y Condiciones</a></li>
                    <li><a href="#privacidad" onclick="openLegalModal('privacy')" class="hover:text-white transition-colors">Política de Privacidad</a></li>
                </ul>
            </div>

            {{-- Columna 4: Compliance y Regulación --}}
            <div class="space-y-3">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Marco Regulatorio</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Operaciones intermediadas bajo supervisión de la <strong>Superintendencia de Seguros de la Nación (SSN)</strong>.
                </p>
                <div class="p-3.5 rounded-xl bg-slate-800/80 border border-slate-700/60 text-xs text-slate-300">
                    <div class="flex items-center gap-2 mb-1.5 text-sky-400 font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Órgano de Control</span>
                    </div>
                    Superintendencia de Seguros de la Nación — 0800-666-8400 — www.argentina.gob.ar/ssn
                </div>
            </div>
        </div>

        {{-- Barra inferior de copyright --}}
        <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
            <p>&copy; {{ date('Y') }} Broker Manager. Todos los derechos reservados.</p>
            <div class="flex items-center gap-6">
                <button type="button" onclick="openLegalModal('terms')" class="hover:text-slate-300 transition-colors">Términos Legales</button>
                <span>&bull;</span>
                <button type="button" onclick="openLegalModal('privacy')" class="hover:text-slate-300 transition-colors">Privacidad de Datos</button>
                <span>&bull;</span>
                <button type="button" onclick="openLegalModal('security')" class="hover:text-slate-300 transition-colors">Seguridad de la Información</button>
            </div>
        </div>
    </div>
</footer>

{{-- Modales Legales Reutilizables (Términos, Privacidad, Seguridad) --}}
<div id="legal-modal-backdrop" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[85vh] flex flex-col shadow-2xl border border-slate-200 animate-in fade-in zoom-in-95 duration-200" role="dialog" aria-modal="true" aria-labelledby="legal-modal-title">
        {{-- Header Modal --}}
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <h2 id="legal-modal-title" class="text-lg font-bold text-slate-900">Documento Legal</h2>
            <button type="button" onclick="closeLegalModal()" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg focus-ring" aria-label="Cerrar ventana">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        {{-- Body Modal --}}
        <div id="legal-modal-body" class="px-6 py-6 overflow-y-auto text-sm text-slate-600 space-y-4 leading-relaxed">
            {{-- Se inyecta dinámicamente con JS --}}
        </div>
        {{-- Footer Modal --}}
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end rounded-b-2xl">
            <button type="button" onclick="closeLegalModal()" class="px-5 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-100 rounded-xl focus-ring">Entendido</button>
        </div>
    </div>
</div>

<script>
    const legalContents = {
        terms: {
            title: 'Términos y Condiciones de Uso del Broker',
            content: `
                <p><strong>1. Alcance de los Servicios:</strong> Broker Manager opera como una plataforma tecnológica y de asesoramiento integral de corretaje de seguros, coordinando solicitudes, cotizaciones y emisiones con aseguradoras legalmente habilitadas por la Superintendencia de Seguros de la Nación (SSN).</p>
                <p><strong>2. Exactitud de las Declaraciones Juradas:</strong> El usuario, tomador o asegurado asume la total responsabilidad por la veracidad de los datos aportados (vehículos, inspecciones, estado de salud o características de inmuebles). Cualquier falsedad o reticencia puede anular la cobertura conforme a la Ley de Seguros 17.418.</p>
                <p><strong>3. Vigencia y Validez de Cotizaciones:</strong> Las cotizaciones presentadas son informativas y reflejan las condiciones vigentes al momento de la consulta. La formalización definitiva del seguro se perfecciona con la emisión de la póliza por parte de la aseguradora elegida.</p>
                <p><strong>4. Cancelaciones y Anulaciones:</strong> El asegurado podrá solicitar la rescisión de su póliza en los términos previstos por la póliza contratada y la normativa legal aplicable.</p>
            `
        },
        privacy: {
            title: 'Política de Privacidad y Protección de Datos Personales',
            content: `
                <p><strong>1. Protección de Datos (Ley 25.326):</strong> Toda la información personal provista (CUIT, correo, teléfono, domicilio y documentación digital) es resguardada bajo estrictas medidas de confidencialidad y utilizada exclusivamente para la cotización, emisión, cobro y atención de siniestros de sus pólizas.</p>
                <p><strong>2. Almacenamiento Seguro:</strong> Los documentos adjuntos se almacenan en repositorios cifrados en la nube con controles de acceso basados en roles (RBAC).</p>
                <p><strong>3. Derechos ARCO:</strong> El titular de los datos personales tiene la facultad de ejercer el derecho de acceso, rectificación y supresión de los mismos mediante solicitud formal dirigida a nuestra mesa de ayuda.</p>
            `
        },
        security: {
            title: 'Seguridad de la Información y Arquitectura Transaccional',
            content: `
                <p><strong>1. Trazabilidad Inmutable:</strong> Cada operación contable y movimiento de caja cuenta con identificadores UUID y registros auditados de saldos, previniendo alteraciones retrospectivas.</p>
                <p><strong>2. Acceso Basado en Roles Estrictos:</strong> La plataforma restringe las funciones administrativas exclusivamente a usuarios con credenciales activas, verificadas y con roles de supervisión autorizados.</p>
                <p><strong>3. Conexiones Cifradas:</strong> Todo el tráfico entre clientes, oficinas y el backend viaja mediante canales seguros TLS/HTTPS de última generación.</p>
            `
        }
    };

    function openLegalModal(type) {
        const modal = document.getElementById('legal-modal-backdrop');
        const titleEl = document.getElementById('legal-modal-title');
        const bodyEl = document.getElementById('legal-modal-body');
        
        if (legalContents[type]) {
            titleEl.textContent = legalContents[type].title;
            bodyEl.innerHTML = legalContents[type].content;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeLegalModal() {
        const modal = document.getElementById('legal-modal-backdrop');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.getElementById('legal-modal-backdrop')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeLegalModal();
        }
    });
</script>
