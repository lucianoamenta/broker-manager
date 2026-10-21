<?php

namespace Database\Seeders;

use App\Models\BusinessActivity;
use App\Models\CashMovementFileType;
use App\Models\CashMovementType;
use App\Models\CashRegisterType;
use App\Models\DepartmentFileType;
use App\Models\EmployeeType;
use App\Models\FiscalCondition;
use App\Models\Gender;
use App\Models\InsurerFileType;
use App\Models\MaritalStatus;
use App\Models\OfficeFileType;
use App\Models\OrganizationFileType;
use App\Models\PasRegistrationFileType;
use App\Models\PaymentFileType;
use App\Models\PolicyFileType;
use App\Models\QuoteFileType;
use App\Models\VoucherType;
use App\Models\ZoneFileType;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================================
        // 1. MARITAL STATUSES (Estados Civiles)
        // Propósito: Opciones de estado civil necesarias para legajos personales y
        // validaciones de KYC (Know Your Customer) bajo regulaciones de compliance.
        // =========================================================================
        $this->command->info('Seeding: Marital Statuses...');

        $maritalStatuses = [
            ['name' => MaritalStatus::NOT_SPEC_TYPE, 'code' => MaritalStatus::NOT_SPEC_CODE],
            ['name' => MaritalStatus::SINGLE_TYPE, 'code' => MaritalStatus::SINGLE_CODE],
            ['name' => MaritalStatus::MARRIED_TYPE, 'code' => MaritalStatus::MARRIED_CODE],
            ['name' => MaritalStatus::DIVORCED_TYPE, 'code' => MaritalStatus::DIVORCED_CODE],
            ['name' => MaritalStatus::WIDOWED_TYPE, 'code' => MaritalStatus::WIDOWED_CODE],
            ['name' => MaritalStatus::CONCUBINAGE_TYPE, 'code' => MaritalStatus::CONCUBINAGE_CODE],
        ];

        foreach ($maritalStatuses as $maritalStatus) {
            MaritalStatus::create($maritalStatus);
        }

        // =========================================================================
        // 2. GENDERS (Géneros)
        // Propósito: Opciones de género requeridas para el perfilamiento oficial de
        // personas físicas y declaraciones juradas.
        // =========================================================================
        $this->command->info('Seeding: Genders...');

        $genders = [
            ['name' => Gender::NOT_SPEC_TYPE, 'code' => Gender::NOT_SPEC_CODE],
            ['name' => Gender::MALE_TYPE, 'code' => Gender::MALE_CODE],
            ['name' => Gender::FEMALE_TYPE, 'code' => Gender::FEMALE_CODE],
            ['name' => Gender::NOT_BIN_TYPE, 'code' => Gender::NOT_BIN_CODE],
            ['name' => Gender::NOT_GENDER_TYPE, 'code' => Gender::NOT_GENDER_CODE],
        ];

        foreach ($genders as $gender) {
            Gender::create($gender);
        }

        // =========================================================================
        // 3. Business Activities (Actividades Comerciales)
        // Propósito: Rubros económicos para clasificar actividad comercial,
        // aplicar retenciones y categorizar empresas/empleados.
        // =========================================================================
        $this->command->info('Seeding: Business Activities...');

        $activities = [
            ['name' => BusinessActivity::NOT_SPEC_TYPE, 'code' => BusinessActivity::NOT_SPEC_CODE, 'description' => 'No se especificó la actividad comercial'],
            ['name' => 'Compañía de seguros', 'code' => 'cmpsegu', 'description' => 'Proveer servicios de seguros para personas y empresas.'],
            ['name' => 'Banco comercial', 'code' => 'bnkcomm', 'description' => 'Ofrecer servicios financieros como préstamos, cuentas bancarias y tarjetas de crédito.'],
            ['name' => 'Constructora', 'code' => 'constru', 'description' => 'Desarrollar proyectos inmobiliarios y construir infraestructuras.'],
            ['name' => 'Empresa de tecnología', 'code' => 'techent', 'description' => 'Desarrollar software, aplicaciones y soluciones tecnológicas.'],
            ['name' => 'Supermercado', 'code' => 'suprmkt', 'description' => 'Vender productos alimenticios y de consumo masivo al público.'],
            ['name' => 'Fábrica de automóviles', 'code' => 'autofak', 'description' => 'Diseñar y producir vehículos para el mercado nacional e internacional.'],
            ['name' => 'Consultora empresarial', 'code' => 'consult', 'description' => 'Brindar asesoramiento estratégico y operativo a otras empresas.'],
            ['name' => 'Clínica médica', 'code' => 'clinmed', 'description' => 'Proporcionar servicios de salud y atención médica especializada.'],
            ['name' => 'Aerolínea', 'code' => 'airline', 'description' => 'Ofrecer servicios de transporte aéreo de pasajeros y carga.'],
            ['name' => 'Hotel', 'code' => 'hotelco', 'description' => 'Proporcionar alojamiento y servicios de hospedaje a turistas y viajeros.'],
            ['name' => 'Agencia de publicidad', 'code' => 'adagncy', 'description' => 'Crear campañas publicitarias y estrategias de marketing.'],
            ['name' => 'Escuela privada', 'code' => 'privsch', 'description' => 'Impartir educación formal a estudiantes de todos los niveles.'],
            ['name' => 'Fábrica textil', 'code' => 'textile', 'description' => 'Producir ropa, calzado y otros productos textiles.'],
            ['name' => 'Compañía farmacéutica', 'code' => 'pharmak', 'description' => 'Investigar, desarrollar y distribuir medicamentos y productos de salud.'],
            ['name' => 'Distribuidora de alimentos', 'code' => 'foodist', 'description' => 'Suministrar productos alimenticios a restaurantes y tiendas.'],
            ['name' => 'Empresa de logística', 'code' => 'logistc', 'description' => 'Gestionar el transporte y distribución de mercancías.'],
            ['name' => 'Desarrolladora inmobiliaria', 'code' => 'realest', 'description' => 'Comprar, vender y gestionar propiedades residenciales y comerciales.'],
            ['name' => 'Productora de cine', 'code' => 'moviepr', 'description' => 'Crear contenido audiovisual para cine y televisión.'],
            ['name' => 'Laboratorio de análisis clínicos', 'code' => 'labtest', 'description' => 'Realizar pruebas médicas y diagnósticos de laboratorio.'],
            ['name' => 'Empresa de telecomunicaciones', 'code' => 'telcomu', 'description' => 'Proveer servicios de internet, telefonía y televisión por cable.'],
            ['name' => 'Cooperativa de servicios públicos', 'code' => 'cooperative', 'description' => 'Cooperativa que brinda servicios de luz, agua, gas o internet.'],
            ['name' => 'Proveedor de servicios de pago', 'code' => 'pspcp', 'description' => 'Proveer servicios de pago y soluciones financieras digitales, incluyendo billeteras virtuales, cuentas de pago, transferencias y otros servicios de tecnología financiera (fintech).'],
        ];

        foreach ($activities as $activity) {
            BusinessActivity::create($activity);
        }

        // =========================================================================
        // 4. Fiscal Conditions (Condiciones Fiscales)
        // Propósito: Situación impositiva frente al IVA (ARCA/AFIP) crítica para
        // emitir y recibir comprobantes válidos (A, B, Exento, etc.).
        // =========================================================================
        $this->command->info('Seeding: Fiscal Conditions...');

        $fiscalConditionData = [
            ['name' => FiscalCondition::NOT_SPEC_TYPE, 'code' => FiscalCondition::NOT_SPEC_CODE],
            ['name' => FiscalCondition::CF_TYPE, 'code' => FiscalCondition::CF_CODE],
            ['name' => FiscalCondition::RN_TYPE, 'code' => FiscalCondition::RN_CODE],
            ['name' => FiscalCondition::RNI_TYPE, 'code' => FiscalCondition::RNI_CODE],
            ['name' => FiscalCondition::EX_TYPE, 'code' => FiscalCondition::EX_CODE],
            ['name' => FiscalCondition::RM_TYPE, 'code' => FiscalCondition::RM_CODE],
            ['name' => FiscalCondition::NC_TYPE, 'code' => FiscalCondition::NC_CODE],
            ['name' => FiscalCondition::NR_TYPE, 'code' => FiscalCondition::NR_CODE],
        ];

        foreach ($fiscalConditionData as $fiscalCondition) {
            FiscalCondition::create($fiscalCondition);
        }

        // =========================================================================
        // 5. Employee Types (Tipos de Empleados)
        // Propósito: Clasificación de funciones de nuestro personal interno
        // (Superadmin, Administrador, Operador, Bot automatizado).
        // =========================================================================
        $this->command->info('Seeding: Employee Types...');

        $typesEmployees = [
            ['name' => EmployeeType::TYPE_GOD, 'code' => EmployeeType::CODE_GOD, 'description' => 'Super administrador con acceso total'],
            ['name' => EmployeeType::TYPE_ADMIN, 'code' => EmployeeType::CODE_ADMIN, 'description' => 'Administrador general del broker'],
            ['name' => EmployeeType::TYPE_OPERATOR, 'code' => EmployeeType::CODE_OPERATOR, 'description' => 'Operador interno de gestión y atención al cliente'],
            ['name' => EmployeeType::TYPE_BOT, 'code' => EmployeeType::CODE_BOT, 'description' => 'Usuario para procesos automatizados e integraciones'],
            ['name' => EmployeeType::TYPE_MARKETING, 'code' => EmployeeType::CODE_MARKETING, 'description' => 'Especialista en marketing, promociones y campañas'],
            ['name' => EmployeeType::TYPE_TREASURER, 'code' => EmployeeType::CODE_TREASURER, 'description' => 'Gestión y control de tesorería y finanzas'],
            ['name' => EmployeeType::TYPE_AUDITOR, 'code' => EmployeeType::CODE_AUDITOR, 'description' => 'Auditoría interna, compliance y control'],
            ['name' => EmployeeType::TYPE_LAWYER, 'code' => EmployeeType::CODE_LAWYER, 'description' => 'Asesoría legal, siniestros complejos y contratos'],
        ];

        foreach ($typesEmployees as $type) {
            EmployeeType::firstOrCreate(['code' => $type['code']], $type);
        }

        // =========================================================================
        // 6. Cash Register Types (Tipos de Caja Registradora)
        // Propósito: Clasificación operativa de cajas (Física, Virtual, Bancaria).
        // =========================================================================
        $this->command->info('Seeding: Cash Register Types...');

        $cashRegisterTypes = [
            [
                'name' => CashRegisterType::TYPE_PHYSICAL,
                'code' => CashRegisterType::CODE_PHYSICAL,
                'description' => 'Caja registradora para cobros en efectivo en sucursal',
            ],
            [
                'name' => CashRegisterType::TYPE_VIRTUAL,
                'code' => CashRegisterType::CODE_VIRTUAL,
                'description' => 'Caja lógica para pasarelas, transferencias o cobros digitales',
            ],
            [
                'name' => CashRegisterType::TYPE_BANK,
                'code' => CashRegisterType::CODE_BANK,
                'description' => 'Cuenta bancaria operativa de la organización',
            ],
        ];

        foreach ($cashRegisterTypes as $registerType) {
            CashRegisterType::firstOrCreate(['code' => $registerType['code']], $registerType);
        }

        // =========================================================================
        // 7. Voucher Types (Tipos de Comprobante / Recibo de Pago)
        // Propósito: Clasificación legal y contable de los recibos emitidos al cliente.
        // =========================================================================
        $this->command->info('Seeding: Voucher Types...');

        $voucherTypes = [
            [
                'name' => VoucherType::NAME_OFFICIAL_RECEIPT,
                'code' => VoucherType::CODE_OFFICIAL_RECEIPT,
                'description' => 'Recibo oficial emitido al cliente con validez legal por cobranza de seguro',
            ],
            [
                'name' => VoucherType::NAME_PAYMENT_PROOF,
                'code' => VoucherType::CODE_PAYMENT_PROOF,
                'description' => 'Comprobante simple o provisorio de recepción de fondos',
            ],
            [
                'name' => VoucherType::NAME_PROVISIONAL_RECEIPT,
                'code' => VoucherType::CODE_PROVISIONAL_RECEIPT,
                'description' => 'Recibo manual o provisorio extendido en calle por recaudadores',
            ],
        ];

        foreach ($voucherTypes as $voucherType) {
            VoucherType::firstOrCreate(['code' => $voucherType['code']], $voucherType);
        }

        // =========================================================================
        // 8. Cash Movement Types (Tipos de Movimiento de Caja)
        // Propósito: Catálogo estandarizado de operaciones contables de ingresos y egresos.
        // =========================================================================
        $this->command->info('Seeding: Cash Movement Types...');

        $cashMovementTypes = [
            [
                'name' => CashMovementType::NAME_OPENING,
                'code' => CashMovementType::CODE_OPENING,
                'default_effect' => CashMovementType::EFFECT_NEUTRAL,
                'description' => 'Inicio de jornada o turno en caja registradora',
            ],
            [
                'name' => CashMovementType::NAME_POLICY_PAYMENT,
                'code' => CashMovementType::CODE_POLICY_PAYMENT,
                'default_effect' => CashMovementType::EFFECT_CREDIT,
                'description' => 'Cobro de cuota o premio de seguro en sucursal',
            ],
            [
                'name' => CashMovementType::NAME_MANUAL_INCOME,
                'code' => CashMovementType::CODE_MANUAL_INCOME,
                'default_effect' => CashMovementType::EFFECT_CREDIT,
                'description' => 'Ingreso de efectivo extraordinario o cambio operativo',
            ],
            [
                'name' => CashMovementType::NAME_COLLECTOR_SETTLEMENT,
                'code' => CashMovementType::CODE_COLLECTOR_SETTLEMENT,
                'default_effect' => CashMovementType::EFFECT_CREDIT,
                'description' => 'Ingreso por sobre o lote de cobranza de recaudadores en calle',
            ],
            [
                'name' => CashMovementType::NAME_TREASURY_TRANSFER,
                'code' => CashMovementType::CODE_TREASURY_TRANSFER,
                'default_effect' => CashMovementType::EFFECT_DEBIT,
                'description' => 'Descarga de excedente de efectivo hacia caja fuerte o tesorería',
            ],
            [
                'name' => CashMovementType::NAME_SERVICE_PAYMENT,
                'code' => CashMovementType::CODE_SERVICE_PAYMENT,
                'default_effect' => CashMovementType::EFFECT_DEBIT,
                'description' => 'Pago directo de facturas o servicios menores desde la caja',
            ],
            [
                'name' => CashMovementType::NAME_OPERATING_EXPENSE,
                'code' => CashMovementType::CODE_OPERATING_EXPENSE,
                'default_effect' => CashMovementType::EFFECT_DEBIT,
                'description' => 'Gastos corrientes de librería, limpieza o refrigerio',
            ],
            [
                'name' => CashMovementType::NAME_SURPLUS_ADJUSTMENT,
                'code' => CashMovementType::CODE_SURPLUS_ADJUSTMENT,
                'default_effect' => CashMovementType::EFFECT_CREDIT,
                'description' => 'Ajuste contable por sobrante detectado en el cierre',
            ],
            [
                'name' => CashMovementType::NAME_DEFICIT_ADJUSTMENT,
                'code' => CashMovementType::CODE_DEFICIT_ADJUSTMENT,
                'default_effect' => CashMovementType::EFFECT_DEBIT,
                'description' => 'Ajuste contable por faltante detectado en el arqueo',
            ],
            [
                'name' => CashMovementType::NAME_CLOSING,
                'code' => CashMovementType::CODE_CLOSING,
                'default_effect' => CashMovementType::EFFECT_NEUTRAL,
                'description' => 'Cierre final de turno y arqueo de caja registradora',
            ],
        ];

        foreach ($cashMovementTypes as $moveType) {
            CashMovementType::firstOrCreate(['code' => $moveType['code']], $moveType);
        }

        // =========================================================================
        // 9. Entity File Types (Tipos de Archivos y Documentos por Entidad)
        // Propósito: Clasificación de adjuntos para pólizas, pagos, cotizaciones y entidades.
        // =========================================================================
        $this->command->info('Seeding: Entity File Types...');

        // Organization File Types
        $orgFileTypes = [
            ['name' => OrganizationFileType::NAME_SOCIAL_STATUTE, 'code' => OrganizationFileType::CODE_SOCIAL_STATUTE, 'description' => 'Estatuto social o contrato de constitución', 'max_size_mb' => 15, 'accepted_formats' => ['pdf']],
            ['name' => OrganizationFileType::NAME_TAX_REGISTRATION, 'code' => OrganizationFileType::CODE_TAX_REGISTRATION, 'description' => 'Constancia de inscripción tributaria oficial', 'max_size_mb' => 5, 'accepted_formats' => ['pdf', 'png', 'jpg']],
            ['name' => OrganizationFileType::NAME_POWER_OF_ATTORNEY, 'code' => OrganizationFileType::CODE_POWER_OF_ATTORNEY, 'description' => 'Poder ante escribano público de representantes', 'max_size_mb' => 10, 'accepted_formats' => ['pdf']],
        ];
        foreach ($orgFileTypes as $item) {
            OrganizationFileType::firstOrCreate(['code' => $item['code']], $item);
        }

        // Insurer File Types
        $insurerFileTypes = [
            ['name' => InsurerFileType::NAME_FRAMEWORK_AGREEMENT, 'code' => InsurerFileType::CODE_FRAMEWORK_AGREEMENT, 'description' => 'Acuerdo comercial y de comisiones con la compañía aseguradora', 'max_size_mb' => 20, 'accepted_formats' => ['pdf']],
            ['name' => InsurerFileType::NAME_SSN_AUTHORIZATION, 'code' => InsurerFileType::CODE_SSN_AUTHORIZATION, 'description' => 'Resolución oficial de la Superintendencia de Seguros', 'max_size_mb' => 10, 'accepted_formats' => ['pdf']],
            ['name' => InsurerFileType::NAME_UNDERWRITING_MANUAL, 'code' => InsurerFileType::CODE_UNDERWRITING_MANUAL, 'description' => 'Normas de suscripción técnica de productos', 'max_size_mb' => 30, 'accepted_formats' => ['pdf']],
        ];
        foreach ($insurerFileTypes as $item) {
            InsurerFileType::firstOrCreate(['code' => $item['code']], $item);
        }

        // PAS Registration File Types
        $pasFileTypes = [
            ['name' => PasRegistrationFileType::NAME_SSN_CREDENTIAL, 'code' => PasRegistrationFileType::CODE_SSN_CREDENTIAL, 'description' => 'Credencial oficial de Productor Asesor de Seguros', 'max_size_mb' => 10, 'accepted_formats' => ['pdf', 'jpg', 'png']],
            ['name' => PasRegistrationFileType::NAME_PROFESSIONAL_SURETY, 'code' => PasRegistrationFileType::CODE_PROFESSIONAL_SURETY, 'description' => 'Seguro de caución exigido por la SSN para ejercer', 'max_size_mb' => 10, 'accepted_formats' => ['pdf']],
            ['name' => PasRegistrationFileType::NAME_AFIP_REGISTRATION, 'code' => PasRegistrationFileType::CODE_AFIP_REGISTRATION, 'description' => 'Constancia impositiva para facturación de comisiones', 'max_size_mb' => 5, 'accepted_formats' => ['pdf']],
        ];
        foreach ($pasFileTypes as $item) {
            PasRegistrationFileType::firstOrCreate(['code' => $item['code']], $item);
        }

        // Quote File Types
        $quoteFileTypes = [
            ['name' => QuoteFileType::NAME_INSURER_PROPOSAL, 'code' => QuoteFileType::CODE_INSURER_PROPOSAL, 'description' => 'Cotización PDF descargada del cotizador oficial', 'max_size_mb' => 10, 'accepted_formats' => ['pdf']],
            ['name' => QuoteFileType::NAME_VEHICLE_INSPECTION_PHOTO, 'code' => QuoteFileType::CODE_VEHICLE_INSPECTION_PHOTO, 'description' => 'Fotografía del estado del auto o moto a asegurar', 'max_size_mb' => 15, 'accepted_formats' => ['jpg', 'png', 'jpeg', 'webp']],
            ['name' => QuoteFileType::NAME_SIGNED_APPLICATION_FORM, 'code' => QuoteFileType::CODE_SIGNED_APPLICATION_FORM, 'description' => 'Solicitud firmada por el asegurado / tomador', 'max_size_mb' => 10, 'accepted_formats' => ['pdf', 'jpg', 'png']],
        ];
        foreach ($quoteFileTypes as $item) {
            QuoteFileType::firstOrCreate(['code' => $item['code']], $item);
        }

        // Policy File Types
        $policyFileTypes = [
            ['name' => PolicyFileType::NAME_OFFICIAL_POLICY_FRONT, 'code' => PolicyFileType::CODE_OFFICIAL_POLICY_FRONT, 'description' => 'Documento oficial con condiciones y números emitida por la aseguradora', 'max_size_mb' => 25, 'accepted_formats' => ['pdf']],
            ['name' => PolicyFileType::NAME_COVERAGE_CERTIFICATE, 'code' => PolicyFileType::CODE_COVERAGE_CERTIFICATE, 'description' => 'Certificado de circulación o constancia de seguro vigente', 'max_size_mb' => 10, 'accepted_formats' => ['pdf']],
            ['name' => PolicyFileType::NAME_MERCOSUR_CARD, 'code' => PolicyFileType::CODE_MERCOSUR_CARD, 'description' => 'Tarjeta obligatoria para circular en vehículos', 'max_size_mb' => 10, 'accepted_formats' => ['pdf', 'png', 'jpg']],
            ['name' => PolicyFileType::NAME_NON_REPETITION_CLAUSE, 'code' => PolicyFileType::CODE_NON_REPETITION_CLAUSE, 'description' => 'Endoso a favor de un comitente o empresa contratante', 'max_size_mb' => 10, 'accepted_formats' => ['pdf']],
        ];
        foreach ($policyFileTypes as $item) {
            PolicyFileType::firstOrCreate(['code' => $item['code']], $item);
        }

        // Payment File Types
        $paymentFileTypes = [
            ['name' => PaymentFileType::NAME_BANK_TRANSFER_RECEIPT, 'code' => PaymentFileType::CODE_BANK_TRANSFER_RECEIPT, 'description' => 'Ticket o constancia de home banking enviada por el cliente', 'max_size_mb' => 10, 'accepted_formats' => ['pdf', 'png', 'jpg', 'jpeg']],
            ['name' => PaymentFileType::NAME_POSNET_SLIP, 'code' => PaymentFileType::CODE_POSNET_SLIP, 'description' => 'Voucher físico o digital de cobro por terminal POS', 'max_size_mb' => 5, 'accepted_formats' => ['png', 'jpg', 'pdf']],
            ['name' => PaymentFileType::NAME_CHECK_PHOTO, 'code' => PaymentFileType::CODE_CHECK_PHOTO, 'description' => 'Frente y dorso de cheque recibido', 'max_size_mb' => 10, 'accepted_formats' => ['jpg', 'png', 'pdf']],
        ];
        foreach ($paymentFileTypes as $item) {
            PaymentFileType::firstOrCreate(['code' => $item['code']], $item);
        }

        // Cash Movement File Types
        $cashMovementFileTypes = [
            ['name' => CashMovementFileType::NAME_EXPENSE_INVOICE, 'code' => CashMovementFileType::CODE_EXPENSE_INVOICE, 'description' => 'Comprobante de compra o servicio pagado por caja chica', 'max_size_mb' => 10, 'accepted_formats' => ['pdf', 'png', 'jpg', 'jpeg']],
            ['name' => CashMovementFileType::NAME_BANK_DEPOSIT_SLIP, 'code' => CashMovementFileType::CODE_BANK_DEPOSIT_SLIP, 'description' => 'Comprobante de depósito en cuenta de la remesa de efectivo', 'max_size_mb' => 10, 'accepted_formats' => ['pdf', 'png', 'jpg']],
            ['name' => CashMovementFileType::NAME_TREASURY_RECEIPT, 'code' => CashMovementFileType::CODE_TREASURY_RECEIPT, 'description' => 'Firma de tesorería al retirar efectivo de la caja sucursal', 'max_size_mb' => 10, 'accepted_formats' => ['pdf', 'png', 'jpg']],
        ];
        foreach ($cashMovementFileTypes as $item) {
            CashMovementFileType::firstOrCreate(['code' => $item['code']], $item);
        }

        // Zone, Department and Office basic file types
        ZoneFileType::firstOrCreate(
            ['code' => ZoneFileType::CODE_JURISDICTION_MAP],
            ['name' => ZoneFileType::NAME_JURISDICTION_MAP, 'code' => ZoneFileType::CODE_JURISDICTION_MAP, 'description' => 'Plano o delimitación territorial de la zona', 'max_size_mb' => 15, 'accepted_formats' => ['pdf', 'png', 'jpg']]
        );

        DepartmentFileType::firstOrCreate(
            ['code' => DepartmentFileType::CODE_PROCEDURES_MANUAL],
            ['name' => DepartmentFileType::NAME_PROCEDURES_MANUAL, 'code' => DepartmentFileType::CODE_PROCEDURES_MANUAL, 'description' => 'Reglamento interno y flujos del departamento', 'max_size_mb' => 20, 'accepted_formats' => ['pdf']]
        );

        OfficeFileType::firstOrCreate(
            ['code' => OfficeFileType::CODE_MUNICIPAL_PERMIT],
            ['name' => OfficeFileType::NAME_MUNICIPAL_PERMIT, 'code' => OfficeFileType::CODE_MUNICIPAL_PERMIT, 'description' => 'Certificado de habilitación comercial de la oficina física', 'max_size_mb' => 10, 'accepted_formats' => ['pdf', 'jpg', 'png']]
        );
    }
}
