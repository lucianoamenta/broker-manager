<?php

namespace Database\Seeders;

use App\Models\BusinessActivity;
use App\Models\CashRegisterType;
use App\Models\EmployeeType;
use App\Models\FiscalCondition;
use App\Models\Gender;
use App\Models\MaritalStatus;
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
            //!TODO: Actualizar bien todos los roles y sus codes para saber que tipo de usuarios pondremos en el sistema
            ['name' => EmployeeType::TYPE_GOD, 'code' => EmployeeType::CODE_GOD, 'description' => 'Super administrador con acceso total'],
            ['name' => EmployeeType::TYPE_ADMIN, 'code' => EmployeeType::CODE_ADMIN, 'description' => 'Administrador del sistema'],
            ['name' => EmployeeType::TYPE_OPERATOR, 'code' => EmployeeType::CODE_OPERATOR, 'description' => 'Operador de atención al cliente'],
            ['name' => EmployeeType::TYPE_BOT, 'code' => EmployeeType::CODE_BOT, 'description' => 'Usuario para procesos automatizados'],
            ['name' => EmployeeType::TYPE_CASHIER, 'code' => EmployeeType::CODE_CASHIER, 'description' => 'Operador de caja registradora y cobranza'],
            ['name' => EmployeeType::TYPE_COLLECTOR, 'code' => EmployeeType::CODE_COLLECTOR, 'description' => 'Recaudador territorial de cobranza'],
            ['name' => EmployeeType::TYPE_ZONE_SUPERVISOR, 'code' => EmployeeType::CODE_ZONE_SUPERVISOR, 'description' => 'Supervisor o gerente de zona'],
            ['name' => EmployeeType::TYPE_DEPARTMENT_HEAD, 'code' => EmployeeType::CODE_DEPARTMENT_HEAD, 'description' => 'Responsable o jefe de departamento'],
            ['name' => EmployeeType::TYPE_PRODUCER, 'code' => EmployeeType::CODE_PRODUCER, 'description' => 'Productor asesor de seguros (PAS)'],
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
    }
}
