<?php

namespace Database\Seeders;

use App\Models\Cashier;
use App\Models\CashRegister;
use App\Models\CashRegisterType;
use App\Models\City;
use App\Models\Collector;
use App\Models\CollectorZone;
use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Gender;
use App\Models\Insurer;
use App\Models\MaritalStatus;
use App\Models\Office;
use App\Models\Organization;
use App\Models\OrganizationInsurer;
use App\Models\OrganizationPasAssignment;
use App\Models\PasRegistration;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InitialScenarioSeeder extends Seeder
{
    /**
     * Construcción integral del escenario inicial de operaciones:
     * - Empleados base (Admin y God) con cuentas de usuario.
     * - 3 Organizaciones operativas con Zonas principales, Oficinas, Cajas (Física/Virtual), Cajeros y Recaudadores.
     * - Matrícula PAS central asignada a las 3 organizaciones.
     * - 4 Aseguradoras comerciales asociadas a las organizaciones.
     */
    public function run(): void
    {
        $this->command->info('Iniciando construcción del escenario inicial...');

        // =========================================================================
        // 0. Determinación dinámica del dominio de correos desde APP_NAME (.env)
        // =========================================================================
        $appName = config('app.name', env('APP_NAME', 'Broker Manager'));
        $domainSlug = Str::slug($appName, '-');
        $emailDomain = $domainSlug.'.com'; // ej: "broker-manager.com"

        $this->command->info("Dominio institucional configurado: @{$emailDomain}");

        // Localidades y catálogos de referencia
        $cityRosario = City::where('name', 'like', '%Rosario%')->first() ?? City::first();
        $cityMendoza = City::where('name', 'like', '%Mendoza%')->first() ?? $cityRosario;
        $cityNeuquen = City::where('name', 'like', '%Neuqu%')->first() ?? $cityRosario;

        $genderMale = Gender::where('code', Gender::MALE_CODE)->first() ?? Gender::first();
        $genderFemale = Gender::where('code', Gender::FEMALE_CODE)->first() ?? Gender::first();
        $genderNotSpec = Gender::where('code', Gender::NOT_SPEC_CODE)->first() ?? Gender::first();

        $maritalSingle = MaritalStatus::where('code', MaritalStatus::SINGLE_CODE)->first() ?? MaritalStatus::first();
        $maritalMarried = MaritalStatus::where('code', MaritalStatus::MARRIED_CODE)->first() ?? MaritalStatus::first();
        $maritalNotSpec = MaritalStatus::where('code', MaritalStatus::NOT_SPEC_CODE)->first() ?? MaritalStatus::first();

        $empTypeAdmin = EmployeeType::findByCode(EmployeeType::CODE_ADMIN);
        $empTypeGod = EmployeeType::findByCode(EmployeeType::CODE_GOD);

        // =========================================================================
        // 1. Usuarios y Empleados Centrales (Admin y God)
        // =========================================================================
        $this->command->info('Creando usuarios y empleados centrales (Admin y God)...');

        // 1.1 Administrador (Luciano Amenta)
        $adminUsername = 'luciano.amenta';
        $adminEmail = "{$adminUsername}@{$emailDomain}";
        $adminUser = User::firstOrCreate(
            ['username' => $adminUsername],
            [
                'uuid' => (string) Str::uuid(),
                'email' => $adminEmail,
                'password' => Hash::make('Abanico$2020'),
                'is_verified' => true,
                'is_allowed' => true,
            ]
        );
        $adminUser->syncRoles([User::ROL_ADMIN]);

        Employee::firstOrCreate(
            ['user_id' => $adminUser->id],
            [
                'uuid' => (string) Str::uuid(),
                'names' => 'Luciano',
                'surnames' => 'Amenta',
                'cuit' => '20-33889911-4',
                'personal_phone' => '+54 341 555-1020',
                'personal_email' => $adminEmail,
                'address' => 'Bv. Oroño 1245',
                'city_id' => $cityRosario->id,
                'gender_id' => $genderMale->id,
                'marital_status_id' => $maritalSingle->id,
                'employee_type_id' => $empTypeAdmin->id,
            ]
        );

        // 1.2 Superadmin God (Oficina Abanico)
        $godUsername = 'oficina.abanico';
        $godEmail = "{$godUsername}@{$emailDomain}";
        $godUser = User::firstOrCreate(
            ['username' => $godUsername],
            [
                'uuid' => (string) Str::uuid(),
                'email' => $godEmail,
                'password' => Hash::make('Abanico$2020'),
                'is_verified' => true,
                'is_allowed' => true,
            ]
        );
        $godUser->syncRoles([User::ROL_GOD]);

        Employee::firstOrCreate(
            ['user_id' => $godUser->id],
            [
                'uuid' => (string) Str::uuid(),
                'names' => 'Oficina',
                'surnames' => 'Abanico',
                'cuit' => '30-70000001-9',
                'personal_phone' => '+54 11 4000-0000',
                'personal_email' => $godEmail,
                'address' => 'Sede Central Broker',
                'city_id' => $cityRosario->id,
                'gender_id' => $genderNotSpec->id,
                'marital_status_id' => $maritalNotSpec->id,
                'employee_type_id' => $empTypeGod->id,
            ]
        );

        // =========================================================================
        // 2. Tres Organizaciones Operativas con Zonas, Oficinas, Cajas y Personal
        // =========================================================================
        $this->command->info('Creando organizaciones territoriales y sus redes operativas...');

        $organizationsData = [
            [
                'org' => [
                    'name' => 'Broker Central Litoral',
                    'legal_name' => 'Broker Central Litoral S.R.L.',
                    'cuit' => '30-71458923-8',
                    'code' => 'ORG-LITORAL',
                    'email' => "contacto.litoral@{$emailDomain}",
                    'phone' => '+54 341 425-8800',
                    'address' => 'Bv. Oroño 1245',
                    'city_id' => $cityRosario->id,
                    'is_active' => true,
                ],
                'zone' => [
                    'name' => 'Zona Litoral y Santa Fe',
                    'code' => 'ZONA-LITORAL',
                    'description' => 'Zona principal operativa Litoral, Rosario y corredor Santa Fe',
                    'email' => "zona.litoral@{$emailDomain}",
                    'phone' => '+54 341 425-8801',
                    'is_active' => true,
                ],
                'office' => [
                    'name' => 'Casa Central Rosario',
                    'code' => 'OFI-ROS-CTR',
                    'description' => 'Sede central de atención y cobranzas Rosario',
                    'phone' => '+54 341 425-8802',
                    'email' => "oficina.rosario@{$emailDomain}",
                    'address' => 'Bv. Oroño 1245',
                    'city_id' => $cityRosario->id,
                    'is_active' => true,
                ],
                'cashiers' => [
                    'name' => 'Martín Gómez',
                    'username' => 'cajero.rosario',
                    'phone' => '+54 341 512-3456',
                    'cuit' => '20-38492018-4',
                    'address' => 'San Lorenzo 1420',
                    'city_id' => $cityRosario->id,
                ],
                'collector' => [
                    'code' => 'REC-LITORAL-01',
                    'name' => 'Lucas Fernández',
                    'username' => 'recaudador.litoral',
                    'phone' => '+54 341 598-7654',
                    'cuit' => '20-35894123-2',
                ],
            ],
            [
                'org' => [
                    'name' => 'Organización Cuyo Seguros',
                    'legal_name' => 'Cuyo Broker de Seguros S.A.',
                    'cuit' => '30-71562341-4',
                    'code' => 'ORG-CUYO',
                    'email' => "contacto.cuyo@{$emailDomain}",
                    'phone' => '+54 261 423-1122',
                    'address' => 'Av. San Martín 850',
                    'city_id' => $cityMendoza->id,
                    'is_active' => true,
                ],
                'zone' => [
                    'name' => 'Zona Cuyo y Gran Mendoza',
                    'code' => 'ZONA-CUYO',
                    'description' => 'Zona principal operativa Mendoza y región de Cuyo',
                    'email' => "zona.cuyo@{$emailDomain}",
                    'phone' => '+54 261 423-1123',
                    'is_active' => true,
                ],
                'office' => [
                    'name' => 'Sucursal Mendoza Peatonal',
                    'code' => 'OFI-MDZ-PEAT',
                    'description' => 'Sucursal operativa comercial Mendoza centro',
                    'phone' => '+54 261 423-1124',
                    'email' => "oficina.mendoza@{$emailDomain}",
                    'address' => 'Av. San Martín 850',
                    'city_id' => $cityMendoza->id,
                    'is_active' => true,
                ],
                'cashiers' => [
                    'name' => 'Sofía Benítez',
                    'username' => 'cajero.mendoza',
                    'phone' => '+54 261 544-7890',
                    'cuit' => '27-39123847-3',
                    'address' => 'Garibaldi 320',
                    'city_id' => $cityMendoza->id,
                ],
                'collector' => [
                    'code' => 'REC-CUYO-01',
                    'name' => 'Emiliano Rossi',
                    'username' => 'recaudador.cuyo',
                    'phone' => '+54 261 588-3344',
                    'cuit' => '20-34871920-5',
                ],
            ],
            [
                'org' => [
                    'name' => 'Broker Patagonia Norte',
                    'legal_name' => 'Patagonia Norte Asesores de Seguros S.A.',
                    'cuit' => '30-71689452-9',
                    'code' => 'ORG-PATAGONIA',
                    'email' => "contacto.patagonia@{$emailDomain}",
                    'phone' => '+54 299 448-3300',
                    'address' => 'Av. Argentina 420',
                    'city_id' => $cityNeuquen->id,
                    'is_active' => true,
                ],
                'zone' => [
                    'name' => 'Zona Alto Valle Patagonia',
                    'code' => 'ZONA-PATAGONIA',
                    'description' => 'Zona principal operativa Neuquén, Cipolletti y Alto Valle',
                    'email' => "zona.patagonia@{$emailDomain}",
                    'phone' => '+54 299 448-3301',
                    'is_active' => true,
                ],
                'office' => [
                    'name' => 'Sucursal Neuquén Centro',
                    'code' => 'OFI-NQN-CTR',
                    'description' => 'Sucursal de operaciones comerciales Alto Valle',
                    'phone' => '+54 299 448-3302',
                    'email' => "oficina.neuquen@{$emailDomain}",
                    'address' => 'Av. Argentina 420',
                    'city_id' => $cityNeuquen->id,
                    'is_active' => true,
                ],
                'cashiers' => [
                    'name' => 'Camila Morales',
                    'username' => 'cajero.neuquen',
                    'phone' => '+54 299 511-9876',
                    'cuit' => '27-37654321-8',
                    'address' => 'Rivadavia 250',
                    'city_id' => $cityNeuquen->id,
                ],
                'collector' => [
                    'code' => 'REC-PATAGONIA-01',
                    'name' => 'Rodrigo Díaz',
                    'username' => 'recaudador.patagonia',
                    'phone' => '+54 299 533-2211',
                    'cuit' => '20-36123456-7',
                ],
            ],
        ];

        $cashTypePhysical = CashRegisterType::findByCode(CashRegisterType::CODE_PHYSICAL);
        $cashTypeVirtual = CashRegisterType::findByCode(CashRegisterType::CODE_VIRTUAL);

        $createdOrganizations = [];

        foreach ($organizationsData as $data) {
            // 2.1 Organización
            $orgData = array_merge($data['org'], ['uuid' => (string) Str::uuid()]);
            $org = Organization::firstOrCreate(
                ['code' => $data['org']['code']],
                $orgData
            );
            $createdOrganizations[] = $org;

            // 2.2 Zona Principal
            $zoneData = array_merge($data['zone'], [
                'uuid' => (string) Str::uuid(),
                'organization_id' => $org->id,
            ]);
            $zone = Zone::firstOrCreate(
                ['code' => $data['zone']['code']],
                $zoneData
            );

            // 2.3 Oficina en la Zona
            $officeData = array_merge($data['office'], [
                'uuid' => (string) Str::uuid(),
                'zone_id' => $zone->id,
            ]);
            $office = Office::firstOrCreate(
                ['code' => $data['office']['code']],
                $officeData
            );

            // 2.4 Cajas Registradoras (Física y Virtual)
            CashRegister::firstOrCreate(
                ['code' => "CAJA-{$office->code}-FIS"],
                [
                    'uuid' => (string) Str::uuid(),
                    'office_id' => $office->id,
                    'cash_register_type_id' => $cashTypePhysical->id,
                    'name' => "Caja Física {$office->name}",
                    'balance' => 0.00,
                    'is_open' => false,
                    'is_active' => true,
                ]
            );

            CashRegister::firstOrCreate(
                ['code' => "CAJA-{$office->code}-VIR"],
                [
                    'uuid' => (string) Str::uuid(),
                    'office_id' => $office->id,
                    'cash_register_type_id' => $cashTypeVirtual->id,
                    'name' => "Caja Digital / Virtual {$office->name}",
                    'balance' => 0.00,
                    'is_open' => false,
                    'is_active' => true,
                ]
            );

            // 2.5 Usuario y Cajero asignado a la Oficina
            $cashierUser = User::firstOrCreate(
                ['username' => $data['cashiers']['username']],
                [
                    'uuid' => (string) Str::uuid(),
                    'email' => "{$data['cashiers']['username']}@{$emailDomain}",
                    'password' => Hash::make('Cajero$2020'),
                    'is_verified' => true,
                    'is_allowed' => true,
                ]
            );
            $cashierUser->syncRoles([User::ROL_CASHIER]);

            Cashier::firstOrCreate(
                ['user_id' => $cashierUser->id],
                [
                    'uuid' => (string) Str::uuid(),
                    'office_id' => $office->id,
                    'full_name' => $data['cashiers']['name'],
                    'personal_email' => "{$data['cashiers']['username']}@{$emailDomain}",
                    'personal_phone' => $data['cashiers']['phone'],
                    'cuit' => $data['cashiers']['cuit'],
                    'address' => $data['cashiers']['address'],
                    'city_id' => $data['cashiers']['city_id'],
                    'is_active' => true,
                ]
            );

            // 2.6 Usuario y Recaudador asignado a la Organización y vinculado a la Zona
            $collectorUser = User::firstOrCreate(
                ['username' => $data['collector']['username']],
                [
                    'uuid' => (string) Str::uuid(),
                    'email' => "{$data['collector']['username']}@{$emailDomain}",
                    'password' => Hash::make('Recaudador$2020'),
                    'is_verified' => true,
                    'is_allowed' => true,
                ]
            );
            $collectorUser->syncRoles([User::ROL_COLLECTOR]);

            $collector = Collector::firstOrCreate(
                ['code' => $data['collector']['code']],
                [
                    'uuid' => (string) Str::uuid(),
                    'organization_id' => $org->id,
                    'user_id' => $collectorUser->id,
                    'full_name' => $data['collector']['name'],
                    'cuit' => $data['collector']['cuit'],
                    'personal_phone' => $data['collector']['phone'],
                    'personal_email' => "{$data['collector']['username']}@{$emailDomain}",
                    'is_active' => true,
                ]
            );

            // Asignar el recaudador a la zona principal de su organización
            CollectorZone::firstOrCreate(
                [
                    'collector_id' => $collector->id,
                    'zone_id' => $zone->id,
                ],
                [
                    'uuid' => (string) Str::uuid(),
                    'assigned_at' => now(),
                    'assigned_by_user_id' => $adminUser->id,
                ]
            );
        }

        // =========================================================================
        // 3. Matrícula de Productor Asesor de Seguros (PAS)
        // =========================================================================
        $this->command->info('Creando matrícula PAS principal y asignación a organizaciones...');

        $pas = PasRegistration::firstOrCreate(
            ['registration_number' => '85420'],
            [
                'uuid' => (string) Str::uuid(),
                'full_name' => 'Abanico Seguros Matrícula Principal',
                'cuit' => '20-33445566-9',
                'is_individual' => true,
                'email' => "matricula.principal@{$emailDomain}",
                'phone' => '+54 341 425-8800',
                'address' => 'Bv. Oroño 1245',
                'city_id' => $cityRosario->id,
                'valid_from' => '2020-01-01',
                'valid_until' => '2030-12-31',
                'is_active' => true,
            ]
        );

        // Asignación de la matrícula PAS a las 3 organizaciones
        foreach ($createdOrganizations as $organization) {
            OrganizationPasAssignment::firstOrCreate(
                [
                    'organization_id' => $organization->id,
                    'pas_registration_id' => $pas->id,
                    'zone_id' => null, // Aplica para toda la organización
                ],
                [
                    'uuid' => (string) Str::uuid(),
                    'is_active' => true,
                ]
            );
        }

        // =========================================================================
        // 4. Compañías de Seguros (Insurers) con datos reales y convenios
        // =========================================================================
        $this->command->info('Creando las 4 compañías aseguradoras y asociando a organizaciones...');

        $insurersData = [
            [
                'name' => 'Finisterre Seguros',
                'legal_name' => 'Finisterre Compañía Argentina de Seguros S.A.',
                'cuit' => '30-71192837-1',
                'code' => 'finisterre',
                'ssn_code' => '0854',
                'email' => 'contacto@finisterreseguros.com.ar',
                'phone' => '+54 11 5272-9000',
                'web_url' => 'https://finisterreseguros.com.ar',
                'settings' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Antártida Seguros',
                'legal_name' => 'Antártida Compañía Argentina de Seguros S.A.',
                'cuit' => '30-50005128-4',
                'code' => 'antartida',
                'ssn_code' => '0189',
                'email' => 'info@antartidaseguros.com.ar',
                'phone' => '+54 11 4322-8000',
                'web_url' => 'https://antartidaseguros.com.ar',
                'settings' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Providencia Seguros',
                'legal_name' => 'Providencia Compañía Argentina de Seguros S.A.',
                'cuit' => '30-50003975-6',
                'code' => 'providencia',
                'ssn_code' => '0067',
                'email' => 'info@providenciaseguros.com.ar',
                'phone' => '+54 11 5258-2000',
                'web_url' => 'https://providenciaseguros.com.ar',
                'settings' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Rivadavia Seguros',
                'legal_name' => 'Seguros Rivadavia Cooperativa Limitada',
                'cuit' => '30-50005154-3',
                'code' => 'rivadavia',
                'ssn_code' => '0198',
                'email' => 'info@segurosrivadavia.com',
                'phone' => '+54 810 999-3200',
                'web_url' => 'https://www.segurosrivadavia.com',
                'settings' => null,
                'is_active' => true,
            ],
        ];

        $createdInsurers = [];
        foreach ($insurersData as $insData) {
            $insurerData = array_merge($insData, ['uuid' => (string) Str::uuid()]);
            $createdInsurers[] = Insurer::firstOrCreate(
                ['code' => $insData['code']],
                $insurerData
            );
        }

        // Habilitar las 4 aseguradoras en las 3 organizaciones creadas
        foreach ($createdOrganizations as $organization) {
            foreach ($createdInsurers as $insurer) {
                OrganizationInsurer::firstOrCreate(
                    [
                        'organization_id' => $organization->id,
                        'insurer_id' => $insurer->id,
                    ],
                    [
                        'uuid' => (string) Str::uuid(),
                        'is_active' => true,
                    ]
                );
            }
        }

        $this->command->info('Escenario inicial construido exitosamente.');

        /*
         * =========================================================================
         * 📝 NOTAS DE ARQUITECTURA Y PRÓXIMAS EXTENSIONES DEL ESCENARIO (ROADMAP)
         * =========================================================================
         * Cuando se decida avanzar con las siguientes capas del escenario, se pueden
         * incorporar los siguientes registros complementarios:
         *
         * 1. Ramos y Productos Comerciales (Bloque 2):
         *    - InsuranceBranch: Automotores, Hogar, Caución, Vida, Comercio.
         *    - InsuranceProduct: Productos por rama de cada una de las 4 aseguradoras.
         *    - CoverageDefinition: Coberturas (Responsabilidad Civil, Robo, Incendio, etc.).
         *
         * 2. Clientes Globales y Bienes Asegurables (Bloque 3):
         *    - Party: Clientes testigo (personas físicas con DNI y jurídicas con CUIT).
         *    - InsuredRisk: Bienes asegurables asociados mediante InsuredRiskType.
         *    - Vehicle / Property: Datos específicos de patente, modelo, o dirección.
         *
         * 3. Cotizaciones y Pólizas Activas (Bloque 4):
         *    - Quote: Cotizaciones en curso con desglose de prima vs premio.
         *    - Policy: Pólizas emitidas vinculadas a la cotización y al PAS.
         *
         * 4. Operaciones de Caja y Cobranza en Vivo (Bloque 5):
         *    - CashSession: Apertura de sesión de caja física para el cajero.
         *    - Payment: Cobro de cuota 1 de póliza con comprobante Voucher.
         *    - CashMovement: Asiento contable en caja con efecto de crédito y saldo actualizado.
         *    - CommissionDistribution: Cálculo y congelamiento de comisiones por cobrar.
         */
    }
}
