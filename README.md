# 🛡️ Broker Manager — Backend Core

> **Ecosistema empresarial de alta escalabilidad para la administración integral, operativa, comercial y financiera de Brokers de Seguros.**  
> Desarrollado sobre **Laravel 13** y **PHP 8.3+ / 8.5**, bajo estándares de arquitectura limpia, seguridad por diseño (*Security by Design*), trazabilidad histórica inmutable y desacople estricto entre identidad, jerarquía organizativa y permisos de acceso.

---

## 📌 Tabla de Contenidos

- [Visión del Negocio y Filosofía Arquitectónica](#-visión-del-negocio-y-filosofía-arquitectónica)
- [Fundación Heredada del Boilerplate Base](#-fundación-heredada-del-boilerplate-base)
- [Estructura Modular por Bloques y Migraciones Maestras](#-estructura-modular-por-bloques-y-migraciones-maestras)
  - [Bloque 1: Estructura Organizativa, Territorial y Operativa](#bloque-1-estructura-organizativa-territorial-y-operativa)
  - [Bloque 2: Aseguradoras, Ramos, Productos y Matrículas PAS](#bloque-2-aseguradoras-ramos-productos-y-matrículas-pas)
  - [Bloque 3: Clientes Globales (Parties) y Riesgos Asegurables](#bloque-3-clientes-globales-parties-y-riesgos-asegurables)
  - [Bloque 4: Cotizaciones, Eventos y Pólizas Contratadas](#bloque-4-cotizaciones-eventos-y-pólizas-contratadas)
  - [Bloque 5: Cobranzas, Movimientos de Caja con Efecto, Recibos y Comisiones](#bloque-5-cobranzas-movimientos-de-caja-con-efecto-recibos-y-comisiones)
  - [Bloque 6: Sistema de Archivos y Adjuntos Específicos por Entidad](#bloque-6-sistema-de-archivos-y-adjuntos-específicos-por-entidad)
- [Identidad, Roles y Modelos Eloquent](#-identidad-roles-y-modelos-eloquent)
- [Guía de Instalación y Puesta en Marcha](#-guía-de-instalación-y-puesta-en-marcha)
- [Comandos de Calidad y Formato](#-comandos-de-calidad-y-formato)

---

## 🏛 Visión del Negocio y Filosofía Arquitectónica

El propósito de **Broker Manager** es ser el núcleo transaccional definitivo para empresas de corretaje y gestión de seguros (*brokers*), capaz de reconstruir la historia completa de cada operación económica y contractual:

$$\text{Organización} \longrightarrow \text{Zona} \longrightarrow \text{Oficina} \longrightarrow \text{Cotización} \longrightarrow \text{Póliza} \longrightarrow \text{Pago} \longrightarrow \text{Caja} \longrightarrow \text{Recibo (Voucher)} \longrightarrow \text{Comisión} \longrightarrow \text{Liquidación}$$

### Los Pilares Fundamentales del Sistema:

1. **Separación de Ámbitos vs. Permisos:**  
   Una zona geográfica o un departamento agrupa recursos y define el *alcance de los datos*, pero **no** reemplaza los permisos.
2. **Identidad Desacoplada de las Funciones Operativas:**  
   `User` representa únicamente la credencial de autenticación (relación estricta 1-a-1 `hasOne` con representantes, cajeros, recaudadores y PAS).
3. **Omnicanalidad y Clientes Globales (`parties`):**  
   Los clientes no pertenecen a una organización aislada; son sujetos de derecho globales identificados por su CUIT/DNI. La vinculación comercial surge en la cotización, la póliza o el pago.
4. **Trazabilidad Económica Inmutable:**  
   - Todo ingreso y egreso en efectivo se registra en `cash_movements` con un tipo tipado (`cash_movement_types`), un efecto contable explícito (`credit`, `debit`, `neutral`) y saldos anterior y actual para auditoría instantánea.
   - Cada pago emite un comprobante legal (`vouchers`) y genera una fotografía inmutable de comisión (`commission_distributions`), congelando los porcentajes correspondientes a la aseguradora, el PAS, la oficina y el broker central.

---

## 🧰 Fundación Heredada del Boilerplate Base

El proyecto aprovecha un conjunto de componentes base de nivel bancario ya integrados y testeados:

* **Seguridad Perimetral Híbrida (`HasUuid` + `FindsByIdOrUuid`):** Claves numéricas primarias internas (`id`) para velocidad en índices MySQL, complementadas con identificadores públicos UUID v4 (`uuid`) en cada tabla para evitar ataques IDOR.
* **Control de Códigos Tipados (`HasCode`):** Consultas directas por slug/código amigable en catálogos y entidades maestras (`findOrAbortByCode()`, `findByCode()`).
* **Control de Sesiones y Dispositivos (`UpdateDeviceIp`):** Monitoreo continuo de IPs en tiempo real y expulsión inmediata (`HTTP 403 account_not_active`) ante usuarios inhabilitados.
* **Catálogos Geo-Demográficos Argentinos:**
  * 24 Provincias y todas las localidades del país con Códigos Postales oficiales (`cities`, `provinces`).
  * Condiciones fiscales ARCA/AFIP (`fiscal_conditions`), estados civiles (`marital_statuses`), géneros (`genders`) y 23 rubros de actividad comercial (`business_activities`).
* **Auditoría Polimórfica (`Audit`):** Registro de eventos sensibles con diferencias JSON (*old vs. new*), IP y User-Agent.

---

## 🏢 Estructura Modular por Bloques y Migraciones Maestras

La base de datos se consolida en **7 migraciones maestras y modulares**, evitando la fragmentación caótica de archivos:

```text
database/migrations/
├── 2026_10_20_150000_create_organizations_zones_departments_and_collectors_tables.php  (Bloque 1A)
├── 2026_10_20_150010_create_offices_cash_registers_and_cashiers_tables.php              (Bloque 1B)
├── 2026_10_21_010000_create_insurers_products_and_pas_tables.php                       (Bloque 2)
├── 2026_10_21_010010_create_parties_and_insured_risks_tables.php                       (Bloque 3)
├── 2026_10_21_010020_create_quotes_and_policies_tables.php                              (Bloque 4)
├── 2026_10_21_010030_create_payments_cash_operations_and_commissions_tables.php         (Bloque 5)
└── 2026_10_21_010040_create_entity_files_and_file_types_tables.php                     (Bloque 6)
```

---

### Bloque 1: Estructura Organizativa, Territorial y Operativa

```text
Organización (Broker / Matriz)
├── Representantes Corporativos (Apoderados / Directores)
├── Departamentos Funcionales (Tesorería, Legales, Contabilidad...)
│   └── Representantes de Departamento (Tesorero, Contador, Auditor...)
├── Recaudadores (Personal de cobranza en calle)
│   └── Asignación Histórica a Zonas (collector_zones)
└── Zonas Territoriales (Regiones comerciales)
    ├── Representantes de Zona (Supervisores / Gerentes Zonales)
    └── Oficinas (Sucursales operativas)
        ├── Representantes de Oficina (Responsables de sucursal)
        ├── Cajas Registradoras (Físicas, Virtuales, Bancarias)
        └── Cajeros Asignados (Operadores de ventanilla)
```

* **Modelos:** `Organization`, `OrganizationRepresentative`, `Zone`, `ZoneRepresentative`, `Department`, `DepartmentRepresentative`, `Collector`, `CollectorZone`, `Office`, `OfficeRepresentative`, `CashRegisterType`, `CashRegister`, `Cashier`.

---

### Bloque 2: Aseguradoras, Ramos, Productos y Matrículas PAS

* **`insurers`:** Compañías de seguro con CUIT, código oficial SSN y configuraciones de API.
* **`organization_insurers` & `zone_insurers`:** Habilitación granular de qué aseguradoras comercializa cada organización o zona territorial.
* **`insurance_branches`:** Ramos (Automotores, Hogar, Vida, Accidentes Personales, Caución, Comercio).
* **`insurance_products`:** Productos comerciales ofrecidos por aseguradora en cada ramo.
* **`coverage_definitions`:** Catálogo de coberturas base (RC, Robo, Incendio, Granizo, Deducibles).
* **`pas_registrations`:** Productores Asesores de Seguros matriculados, con flag booleano `is_individual` (persona física vs. sociedad jurídica) y número de matrícula SSN.
* **`organization_pas_assignments`:** Asignación operativa de matrículas a organizaciones y zonas.
* **`insurer_agreements`:** Convenios comerciales y códigos de productor asignados por la aseguradora.
* **Modelos:** `Insurer`, `InsuranceBranch`, `InsuranceProduct`, `CoverageDefinition`, `PasRegistration`, `OrganizationPasAssignment`, `OrganizationInsurer`, `ZoneInsurer`, `InsurerAgreement`.

---

### Bloque 3: Clientes Globales (Parties) y Riesgos Asegurables

* **`parties`:** Sujeto de derecho global (persona física o empresa). No pertenece a una sola organización, facilitando la omnicanalidad (portal web central, sucursales físicas multizona).
* **`insured_risk_types`:** Catálogo estandarizado de tipología de riesgos amparados (`vehicle`, `property`, `surety_bond`, `commercial`, `person`).
* **`insured_risks`:** Cabecera común de bienes o personas asegurables, perteneciente a un `party_id` y tipificada mediante `insured_risk_type_id`.
* **Especializaciones de Riesgo:**
  * `vehicles`: Dominio/patente, marca, modelo, versión, año, motor, chasis/VIN, uso y GNC.
  * `properties`: Inmuebles residenciales, comerciales o industriales, superficie y seguridad.
  * `surety_bonds`: **Seguros de Caución y Garantías** (alquileres, contratos de obra pública/privada, fondos de reparo y aduanas) con beneficiario (`beneficiary_party_id`).
  * `commercial_risks`: Comercios e industrias con rubro de actividad y stock declarado.
  * `insured_people`: Personas aseguradas en pólizas de vida y accidentes personales (AP).
* **Modelos:** `Party`, `InsuredRiskType`, `InsuredRisk`, `Vehicle`, `Property`, `SuretyBond`, `CommercialRisk`, `InsuredPerson`.

---

### Bloque 4: Cotizaciones, Eventos y Pólizas Contratadas

* **`quotes`:** Cotizaciones comerciales guardadas. Permite registrar las ofertas presentadas al cliente con suma asegurada, prima pura (`premium_net`), impuestos (`taxes_amount`) y premio final (`total_amount`).
* **`quote_events`:** Línea de tiempo y auditoría de la cotización (`creacion`, `envio_cliente`, `visto`, `aceptada`, `inspeccion_solicitada`, `enviada_a_emision`, `rechazada`).
* **`policies`:** El contrato oficial emitido. Incluye el vínculo opcional `quote_id`, periodicidad de facturación, desglose técnico estricto de **Prima Neta** vs. **Premio Total**, y vigencias.
* **Tablas Hijas del Contrato:**
  * `policy_parties`: Intervinientes con rol (`tomador`, `asegurado`, `beneficiario`, `titular_pago`) y porcentaje.
  * `policy_risks`: Riesgos amparados (soporta pólizas multi-bien).
  * `policy_coverages`: Coberturas congeladas con límite indemnizatorio y deducible.
  * `policy_transactions`: Endosos de aumento/baja, cambio de unidad, suspensiones y anulaciones.
* **Modelos:** `Quote`, `QuoteEvent`, `Policy`, `PolicyParty`, `PolicyRisk`, `PolicyCoverage`, `PolicyTransaction`.

---

### Bloque 5: Cobranzas, Movimientos de Caja con Efecto, Recibos y Comisiones

* **`cash_movement_types`:** Catálogo estandarizado de operaciones (`apertura`, `cierre`, `cobro_poliza`, `ingreso_manual`, `ingreso_recaudador`, `retiro_tesoreria`, `pago_servicio`, `gasto_operativo`, `ajuste_sobrante`, `ajuste_faltante`).
* **`cash_sessions`:** Control de turnos de caja física (abierta/cerrada, fecha y hora, arqueo).
* **`cash_movements`:** **Libro mayor y extracto de caja en tiempo real.** Cada movimiento tiene su `effect` (`credit`, `debit`, `neutral`), su `amount`, el `previous_balance` y el `current_balance` resultante.
* **`payments`:** Registra el cobro ingresado, la póliza, el número de cuota abonada (`installment_number`, ej. cuota 3 de 6), el canal y método de pago.
* **`voucher_types` & `vouchers`:** Comprobantes legales emitidos al cliente (Recibo Oficial, Constancia de Pago, Recibo Provisorio) con número formal y enlace al PDF generado en S3.
* **`collection_batches` & `collection_settlements`:** Rendición de lotes de cobranza en calle hacia el Departamento de Tesorería, con arqueo de diferencias y actas de recepción.
* **`commission_rules`:** Matriz dinámica de comisiones por aseguradora y producto: % de aseguradora, % para el PAS, % para la oficina y margen retenido por el broker.
* **`commission_distributions`:** **Fotografía inmutable por pago.** Congela la liquidación exacta al momento de cobrar, inmune a futuros cambios de convenio.
* **`commission_settlements`:** Liquidaciones periódicas de honorarios a PAS y oficinas.
* **Modelos:** `VoucherType`, `Voucher`, `CashMovementType`, `CashMovement`, `CashSession`, `Payment`, `CollectionBatch`, `CollectionSettlement`, `CommissionRule`, `CommissionDistribution`, `CommissionSettlement`.

---

### Bloque 6: Sistema de Archivos y Adjuntos Específicos por Entidad

Para evitar confusiones y garantizar tipado estricto sin tablas genéricas sobrecargadas, cada entidad posee su propio catálogo de tipos de archivo permitidos y su tabla de almacenamiento versionado:

| Entidad | Tabla de Tipos | Tabla de Archivos | Propósito Operativo |
| :--- | :--- | :--- | :--- |
| **Organizaciones** | `organization_file_types` | `organization_files` | Estatutos sociales, poderes y constancias impositivas. |
| **Zonas** | `zone_file_types` | `zone_files` | Mapas de jurisdicción y resoluciones comerciales. |
| **Departamentos** | `department_file_types` | `department_files` | Manuales de procedimientos internos y normativas. |
| **Oficinas** | `office_file_types` | `office_files` | Habilitaciones municipales y contratos de locación. |
| **Aseguradoras** | `insurer_file_types` | `insurer_files` | Contratos marco de broker y resoluciones de SSN. |
| **Matrículas PAS** | `pas_registration_file_types` | `pas_registration_files` | Credencial oficial SSN, caución profesional y CUIT. |
| **Cotizaciones** | `quote_file_types` | `quote_files` | Presupuestos PDF de aseguradoras y fotos de inspección. |
| **Pólizas** | `policy_file_types` | `policy_files` | Frente de póliza oficial, certificados y cláusulas. |
| **Pagos** | `payment_file_types` | `payment_files` | Tickets de transferencia bancaria y cupones de POSNET. |
| **Movimientos de Caja** | `cash_movement_file_types` | `cash_movement_files` | Facturas de gastos operativos y boletas de depósito. |

---

## 👥 Identidad, Roles y Modelos Eloquent

### 1. Desacople Estricto de Identidad y Relación 1-a-1 (`User`)
El modelo `User` representa exclusivamente la credencial de autenticación y acceso a la plataforma. No almacena datos del perfil funcional directamente; cada usuario se asocia mediante una relación estricta `hasOne` con la entidad correspondiente:
* `user->employee`: Personal interno de planta (`Employee`) clasificado por `EmployeeType`.
* `user->party`: Cliente asegurado / tomador de póliza (`Party`).
* `user->organizationRepresentative`: Director o apoderado de una organización (`OrganizationRepresentative`).
* `user->zoneRepresentative`: Supervisor o gerente regional (`ZoneRepresentative`).
* `user->departmentRepresentative`: Responsable de área funcional (`DepartmentRepresentative`).
* `user->officeRepresentative`: Encargado de sucursal física (`OfficeRepresentative`).
* `user->cashier`: Operador de caja registradora (`Cashier`).
* `user->collector`: Recaudador territorial en calle (`Collector`).

### 2. Matriz de Roles Estandarizada (`User::ROL_*` & Spatie Permissions)
Los roles están unificados en constantes de `User.php` y se siembran a través de `RolesTableSeeder`:

| Categoría | Constante (`User::*`) | Código del Rol (Slug) | Ámbito y Propósito |
| :--- | :--- | :--- | :--- |
| **Plataforma y Staff** | `ROL_GOD` | `god` | Superadministrador con bypass total de auditoría. |
| | `ROL_ADMIN` | `admin` | Administrador general del broker. |
| | `ROL_EMPLEADO` | `employee` | Operador interno de gestión y atención comercial. |
| | `ROL_BOT` | `bot` | Procesos en segundo plano e integraciones API. |
| | `ROL_MARKETING` | `marketing` | Gestión de campañas y comunicación comercial. |
| | `ROL_TESORERO` | `treasurer` | Control financiero y arqueos de tesorería central. |
| | `ROL_AUDITOR` | `auditor` | Cumplimiento normativo, auditoría y compliance. |
| | `ROL_ABOGADO` | `lawyer` | Gestión legal, reclamos judiciales y contratos. |
| **Jerarquía Territorial** | `ROL_ADMIN_ORGANIZATION` | `admin_organization` | Representante / apoderado de Organización. |
| | `ROL_ADMIN_ZONE` | `admin_zone` | Supervisor o responsable de Zona comercial. |
| | `ROL_ADMIN_DEPARTMENT` | `admin_department` | Jefe de Departamento funcional. |
| | `ROL_ADMIN_OFFICE` | `admin_office` | Encargado o responsable de Oficina/Sucursal. |
| | `ROL_TESORERO_DEPARTMENT`| `treasurer_department` | Responsable de finanzas a nivel departamento. |
| | `ROL_ABOGADO_DEPARTMENT` | `lawyer_department` | Asesor legal específico de departamento. |
| **Sucursal y Cobranza** | `ROL_CASHIER` | `cashier` | Operador asignado a caja física/bancaria. |
| | `ROL_COLLECTOR` | `collector` | Recaudador de cobranza territorial en calle. |
| **Clientes y Asegurados**| `ROL_CLIENTE` | `client` | Sujeto de derecho / tomador (Portal de cliente). |

### 3. Tipos de Empleados Internos (`EmployeeType`)
Para la nómina interna del broker (`employees`), los tipos se gestionan con constantes en `EmployeeType.php` y se siembran en `CatalogSeeder`:
* `TYPE_GOD` (`god`): Super administrador con acceso total.
* `TYPE_ADMIN` (`admin`): Administrador general del broker.
* `TYPE_OPERATOR` (`operator`): Operador interno de atención al cliente (asociado al rol `employee`).
* `TYPE_BOT` (`bot`): Usuario para procesos automatizados.
* `TYPE_MARKETING` (`marketing`): Marketing, promociones y campañas.
* `TYPE_TREASURER` (`treasurer`): Gestión y control de tesorería y finanzas.
* `TYPE_AUDITOR` (`auditor`): Auditoría interna, compliance y control.
* `TYPE_LAWYER` (`lawyer`): Asesoría legal, siniestros complejos y contratos.

### 4. Estándares en Modelos Eloquent
Todos los modelos implementan:
- **`FindsByIdOrUuid` & `HasUuid`:** Búsqueda transparente por ID numérico o UUID en controladores y APIs.
- **`HasCode`:** Resolución instantánea por código único en catálogos y tipos (`findByCode()`).
- **`casts()`:** Fechas tipadas a `date`/`datetime`, importes económicos a `decimal:2`, flags a `boolean` y metadatos a `array`.
- **Relaciones Tipadas:** `BelongsTo`, `HasMany`, `HasOne`, `BelongsToMany` con tipos de retorno estrictos de PHP 8.

---

## 🎭 Escenario Inicial de Operaciones (`InitialScenarioSeeder`)

El seeder `InitialScenarioSeeder` construye automáticamente el entorno base del broker adaptando dinámicamente el dominio de correo según el `APP_NAME` del `.env` (`@broker-manager.com`):

### Cuentas Sembradas para Pruebas y Acceso:

| Rol / Función | Username | Email | Contraseña | Entidad Asociada |
| :--- | :--- | :--- | :--- | :--- |
| **Administrador** | `luciano.amenta` | `luciano.amenta@broker-manager.com` | `Abanico$2020` | Empleado Luciano Amenta |
| **Superadmin God**| `oficina.abanico` | `oficina.abanico@broker-manager.com` | `Abanico$2020` | Empleado Oficina Abanico |
| **Cajero Litoral** | `cajero.rosario` | `cajero.rosario@broker-manager.com` | `Cajero$2020` | Casa Central Rosario |
| **Cajero Cuyo** | `cajero.mendoza` | `cajero.mendoza@broker-manager.com` | `Cajero$2020` | Sucursal Mendoza Peatonal |
| **Cajero Patagonia**| `cajero.neuquen`| `cajero.neuquen@broker-manager.com` | `Cajero$2020` | Sucursal Neuquén Centro |
| **Recaudador Litoral**| `recaudador.litoral` | `recaudador.litoral@broker-manager.com` | `Recaudador$2020` | Zona Litoral y Santa Fe |
| **Recaudador Cuyo**| `recaudador.cuyo` | `recaudador.cuyo@broker-manager.com` | `Recaudador$2020` | Zona Cuyo y Gran Mendoza |
| **Recaudador Patagonia**| `recaudador.patagonia` | `recaudador.patagonia@broker-manager.com` | `Recaudador$2020` | Zona Alto Valle Patagonia |

### Entidades Sembradas:
* **3 Organizaciones:** Broker Central Litoral (`ORG-LITORAL`), Organización Cuyo Seguros (`ORG-CUYO`), Broker Patagonia Norte (`ORG-PATAGONIA`).
* **3 Zonas y 3 Oficinas:** Cada organización posee su zona principal, una sucursal operativa radicada y dos cajas registradoras (1 Física, 1 Digital/Virtual).
* **1 Matrícula PAS:** Matrícula SSN `85420` asignada a las 3 organizaciones.
* **4 Aseguradoras:** Finisterre Seguros, Antártida Seguros, Providencia Seguros y Rivadavia Seguros asociadas con las organizaciones.

---

## 🚀 Guía de Instalación y Puesta en Marcha

### 1. Configuración de Entorno
```bash
composer install
cp .env.example .env
php artisan key:generate
```

### 2. Ejecución de Migraciones y Catálogos
```bash
# Ejecutar todas las migraciones estructurales
php artisan migrate

# Sembrar catálogos maestros y tipos de archivo
php artisan db:seed
```

---

## 🧪 Comandos de Calidad y Formato

El proyecto utiliza **Laravel Pint** bajo estándares estrictos PSR-12:

```bash
# Formatear archivos modificados
vendor/bin/pint --dirty

# Inspeccionar rutas activas
php artisan route:list --except-vendor
```

---

<p align="center">
  <b>Broker Manager</b> • Plataforma integral para la administración inteligente de corretaje de seguros.
</p>
