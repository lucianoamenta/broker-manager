# 🛡️ Broker Manager — Backend Core

> **Ecosistema empresarial de alta escalabilidad para la administración integral, operativa, comercial y financiera de Brokers de Seguros.**  
> Desarrollado sobre **Laravel 13** y **PHP 8.3+ / 8.5**, bajo estándares de arquitectura limpia, seguridad por diseño (*Security by Design*), trazabilidad histórica inmutable y desacople estricto entre identidad, jerarquía organizativa y permisos de acceso.

---

## 📌 Tabla de Contenidos

- [Visión del Negocio y Filosofía Arquitectónica](#-visión-del-negocio-y-filosofía-arquitectónica)
- [Fundación Heredada del Boilerplate Base](#-fundación-heredada-del-boilerplate-base)
- [Módulo 1: Estructura Organizativa, Territorial y Operativa](#-módulo-1-estructura-organizativa-territorial-y-operativa)
  - [Mapa Conceptual de Jerarquías](#mapa-conceptual-de-jerarquías)
  - [Detalle de Tablas y Razón de Ser](#detalle-de-tablas-y-razón-de-ser)
  - [Estrategia de Migraciones Agrupadas](#estrategia-de-migraciones-agrupadas)
- [Identidad, Roles y Tipos de Empleado](#-identidad-roles-y-tipos-de-empleado)
- [Hoja de Ruta de Módulos (Roadmap)](#-hoja-de-ruta-de-módulos-roadmap)
- [Guía de Instalación y Puesta en Marcha](#-guía-de-instalación-y-puesta-en-marcha)
- [Comandos de Calidad y Formato](#-comandos-de-calidad-y-formato)

---

## 🏛 Visión del Negocio y Filosofía Arquitectónica

El propósito de **Broker Manager** es ser el núcleo transaccional definitivo para empresas de corretaje y gestión de seguros (*brokers*), capaz de reconstruir la historia completa de cada operación económica y contractual:

$$\text{Organización} \longrightarrow \text{Zona} \longrightarrow \text{Oficina} \longrightarrow \text{Cotización} \longrightarrow \text{Póliza} \longrightarrow \text{Pago} \longrightarrow \text{Caja} \longrightarrow \text{Comisión} \longrightarrow \text{Liquidación}$$

### Los Cuatro Pilares Fundamentales del Sistema:

1. **Separación de Ámbitos vs. Permisos:**  
   Una zona geográfica o un departamento agrupa recursos y define el *alcance de los datos*, pero **no** reemplaza los permisos. Un usuario puede ser cajero o gerente, pero sus permisos de acción se auditan independientemente de su ámbito geográfico.
2. **Identidad Desacoplada de las Funciones Operativas:**  
   `User` representa únicamente la credencial de autenticación. Las personas que operan el broker tienen representaciones explícitas (`organization_representatives`, `zone_representatives`, `department_representatives`, `cashiers`, `collectors`), lo que permite que una misma identidad mantenga responsabilidades distintas sin viciar el modelo de acceso.
3. **Distinción de las Tres Dimensiones Operativas:**
   * **Dimensión Organizativa:** Quién es dueño del recurso y dónde está radicado.
   * **Dimensión Comercial:** Quién cotiza, qué compañía interviene, qué matrícula PAS se utiliza y qué póliza se emite.
   * **Dimensión Financiera:** Quién recibe el dinero, en qué caja ingresa, cómo viaja con el recaudador y cómo se liquidan las comisiones.
4. **Trazabilidad Económica Inmutable:**  
   Si una póliza generó una liquidación o si una caja registró un arqueo, esa fotografía histórica se preserva para siempre. Cualquier modificación posterior genera un ajuste o transacción compensatoria; nunca se reescribe el pasado.

---

## 🧰 Fundación Heredada del Boilerplate Base

El proyecto aprovecha un conjunto de componentes base de nivel bancario ya integrados y testeados:

* **Seguridad Perimetral Híbrida (`HasUuid` + `FindsByIdOrUuid`):** Claves numéricas primarias internas (`id`) para velocidad en índices MySQL, complementadas con identificadores públicos UUID v4 (`uuid`) en cada tabla para evitar ataques IDOR.
* **Control de Sesiones y Dispositivos (`UpdateDeviceIp`):** Monitoreo continuo de IPs en tiempo real y expulsión inmediata (`HTTP 403 account_not_active`) ante usuarios inhabilitados o no verificados.
* **Catálogos Geo-Demográficos Argentinos:**
  * 24 Provincias y todas las localidades del país con Códigos Postales oficiales (`cities`, `provinces`).
  * Condiciones fiscales ARCA/AFIP (`fiscal_conditions`), estados civiles (`marital_statuses`), géneros (`genders`) y 23 rubros de actividad comercial (`business_activities`).
* **Auditoría Polimórfica (`Audit`):** Registro de eventos sensibles con diferencias JSON (*old vs. new*), IP y User-Agent.
* **Almacenamiento Distribuido (`S3Service`):** Carga y gestión segura de archivos vía AWS S3 / Cloudflare R2 con el Value Object inmutable `StoredFile` y soporte para Base64.
* **Notificaciones Multicanal (`NotificationService`):** Push notifications vía Firebase Cloud Messaging (FCM), SMS/WhatsApp vía Twilio y correos transaccionales vía Mailgun/SMTP.
* **Procesamiento de Webhooks y Respaldos:** Recepción asíncrona con firma HMAC (`spatie/laravel-webhook-client`) y backups automáticos diarios a S3 (`spatie/laravel-backup`).

---

## 🏢 Módulo 1: Estructura Organizativa, Territorial y Operativa

### Mapa Conceptual de Jerarquías

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
        ├── Representantes de Oficina (Responsables / Encargados de sucursal)
        ├── Cajas Registradoras (Físicas, Virtuales, Bancos)
        └── Cajeros Asignados (Operadores de ventanilla)
```

---

### Detalle de Tablas y Razón de Ser

#### 1. `organizations` (Modelo: `Organization`)
* **Por qué existe:** Representa la entidad jurídica o comercial máxima del broker. Permite que el software soporte múltiples empresas independientes o una sola con múltiples razones sociales.
* **Campos clave:** `uuid`, `name`, `legal_name`, `cuit`, `code` (único global), `email`, `phone`, `address`, `city_id`, `web_url`, `url_logo`, `is_active` (boolean), `settings` (JSON para integraciones o preferencias).

#### 2. `organization_representatives` (Modelo: `OrganizationRepresentative`)
* **Por qué existe:** Conecta una cuenta de usuario (`user_id`) con la titularidad legal/directiva de la organización, conservando el nombre completo y datos de contacto directo de la persona física.
* **Campos clave:** `organization_id`, `user_id`, `full_name`, `cuit`, `personal_email`, `personal_phone`, `is_active`. Restricción única `[organization_id, user_id]`.

#### 3. `zones` (Modelo: `Zone`)
* **Por qué existe:** Representa las divisiones territoriales o comerciales de una organización (ej.: "Zona Capital", "Zona Litoral", "Zona Cuyo"). No depende de una oficina; las oficinas dependen de la zona.
* **Campos clave:** `organization_id`, `name`, `code` (único por organización), `description`, `email`, `phone`, `url_logo`, `is_active`.

#### 4. `zone_representatives` (Modelo: `ZoneRepresentative`)
* **Por qué existe:** Identifica formalmente al supervisor, gerente o referente comercial de cada zona, vinculando su usuario de acceso con sus datos personales.
* **Campos clave:** `zone_id`, `user_id`, `full_name`, `cuit`, `personal_email`, `personal_phone`, `is_active`. Restricción única `[zone_id, user_id]`.

#### 5. `departments` (Modelo: `Department`)
* **Por qué existe:** Representa las unidades funcionales del broker (Administración, Contabilidad, Tesorería, Siniestros, Legales, Marketing). A diferencia de las zonas, no tienen radicación geográfica estricta.
* **Campos clave:** `organization_id`, `name`, `code` (único por organización), `description`, `url_logo`, `is_active`.

#### 6. `department_representatives` (Modelo: `DepartmentRepresentative`)
* **Por qué existe:** Asigna formalmente a los jefes de departamento, especificando el cargo o puesto funcional mediante constantes tipadas (`tesorero`, `contador`, `auditor`, `abogado`, `marketing`).
* **Campos clave:** `department_id`, `user_id`, `full_name`, `cuit`, `personal_email`, `personal_phone`, `position`, `is_active`. Restricción única `[department_id, user_id]`.

#### 7. `collectors` (Modelo: `Collector`)
* **Por qué existe:** Modela al personal de recaudación en la calle que cobra cuotas o retira efectivo de sucursales. Son dependientes directos de la organización y tienen su propio usuario de sistema y legajo.
* **Campos clave:** `organization_id`, `user_id`, `code` (legajo único en la organización), `full_name`, `cuit`, `personal_phone`, `personal_email`, `is_active`.

#### 8. `collector_zones` (Modelo: `CollectorZone`)
* **Por qué existe:** Es la tabla intermedia que habilita el tránsito de un recaudador por una o varias zonas territoriales. Cuenta con `assigned_at`, `assigned_by_user_id` (quién lo autorizó) y `SoftDeletes` para garantizar trazabilidad histórica: si se desasigna una zona, queda el registro de qué recaudador cubría esa zona en fechas pasadas.

#### 9. `offices` (Modelo: `Office`)
* **Por qué existe:** Unidad operativa y de atención física a clientes (sucursal). Pertenece a una zona (`zone_id`), por lo que su organización se infiere limpiamente sin redundancia.
* **Campos clave:** `zone_id`, `name`, `code` (único en la zona), `description`, `phone`, `email`, `address`, `city_id`, `url_logo`, `is_active`.

#### 10. `office_representatives` (Modelo: `OfficeRepresentative`)
* **Por qué existe:** Conecta formalmente a los encargados, responsables o directores de sucursal con su respectivo `user_id`, asegurando trazabilidad sobre quién tiene la responsabilidad comercial y operativa de la oficina.
* **Campos clave:** `office_id`, `user_id`, `full_name`, `cuit`, `personal_email`, `personal_phone`, `is_active`. Restricción única `[office_id, user_id]`.

#### 11. `cash_register_types` (Modelo: `CashRegisterType`)
* **Por qué existe:** Catálogo que normaliza el tipo de recurso financiero que representa una caja, utilizando el trait `HasCode`:
  * `physical` (`Caja Física`): Manejo de billetes en efectivo y arqueos de mostrador.
  * `virtual` (`Caja Virtual`): Cobros electrónicos, transferencias o pasarelas de pago.
  * `bank` (`Cuenta Bancaria`): Cuentas bancarias oficiales de liquidación.

#### 12. `cash_registers` (Modelo: `CashRegister`)
* **Por qué existe:** Controla el punto de recepción y custodia de fondos dentro de una oficina.
* **Campos clave:** `office_id`, `cash_register_type_id`, `name`, `code` (único en la oficina), `balance` (decimal con precisión 16,2 para saldo contable), `is_open` (flag booleano que indica si la caja está abierta/operativa en el turno actual), `is_active`.

#### 13. `cashiers` (Modelo: `Cashier`)
* **Por qué existe:** Registra a los operadores de ventanilla autorizados para cobrar en una oficina, vinculando su usuario con sus datos personales y de radicación.
* **Campos clave:** `office_id`, `user_id`, `full_name`, `personal_email`, `personal_phone`, `cuit`, `address`, `city_id`, `is_active`. Restricción única `[office_id, user_id]`.

---

### Estrategia de Migraciones Agrupadas

Para mantener un directorio limpio y cohesivo, las 13 tablas se dividen en dos archivos lógicos:

1. **`create_organizations_zones_departments_and_collectors_tables.php`:**  
   Engloba las organizaciones matrices, sus zonas, departamentos, recaudadores, asignaciones intermedias con soft deletes y sus representantes directos.
2. **`create_offices_cash_registers_and_cashiers_tables.php`:**  
   Engloba las unidades operativas locales: sucursales (`offices`), sus representantes (`office_representatives`), catálogo de tipos de caja (`cash_register_types`), cajas registradoras con control de balance y cajeros asignados.

---

## 👥 Identidad, Roles y Tipos de Empleado

El sistema amplía el control de acceso en dos niveles:

1. **Roles Spatie en `User`:**
   * `god`: Superadministrador de plataforma.
   * `admin`: Administrador general del broker.
   * `zone_manager`: Supervisor o gerente zonal.
   * `department_head`: Responsable de área/departamento.
   * `cashier`: Operador de cobranzas y caja.
   * `collector`: Recaudador territorial.
   * `client`: Cliente tomador o asegurado.
   * `employee`: Personal operativo general.
   * `bot`: Procesos batch / Webhooks.

2. **Categorías Laborales en `EmployeeType`:**
   * `Cajero` (`cashier`)
   * `Recaudador` (`collector`)
   * `Supervisor de Zona` (`zone_supervisor`)
   * `Jefe de Departamento` (`department_head`)
   * `Productor Asesor` (`producer`)
   * `Administrador`, `Operador`, `Bot`.

---

## 🗺️ Hoja de Ruta de Módulos (Roadmap)

El diseño integral de Broker Manager contempla las siguientes fases de desarrollo incremental:

| Fase | Módulo | Entidades Principales | Propósito |
| :---: | :--- | :--- | :--- |
| **1** | **Estructura Organizativa e Identidad** *(Completada)* | `organizations`, `zones`, `offices`, `departments`, `cash_registers`, `collectors`, etc. | Modelado de empresas, sucursales, cajas y personal. |
| **2** | **Aseguradoras, Acuerdos y Habilitaciones** | `insurers`, `insurer_agreements`, `insurance_branches`, `insurance_products`, `insurer_agreement_products` | Compañías aseguradoras, convenios comerciales vigentes y productos autorizados por convenio. |
| **3** | **PAS, Matrículas e Intermediarios** | `insurance_intermediaries`, `pas_registrations`, `organization_intermediary_assignments` | Productores Asesores de Seguros, matrículas SSN verificadas y asignaciones comerciales. |
| **4** | **Clientes y Riesgos Asegurables** | `parties`, `individual_profiles`, `organization_profiles`, `insured_risks`, `vehicles`, `properties` | CRM unificado de asegurados/tomadores y bienes protegidos (autos, inmuebles, personas). |
| **5** | **Cotizaciones y Motor de Elegibilidad** | `quote_requests`, `quotes`, `quote_snapshots`, `quote_eligibility_checks` | Solicitudes, comparador multicompañía y comprobación de habilitación contractual. |
| **6** | **Pólizas y Movimientos Contractuales** | `policies`, `policy_parties`, `policy_risks`, `policy_coverages`, `policy_transactions` | Emisiones, endosos, renovaciones, cancelaciones y resguardo de condiciones contractuales. |
| **7** | **Cobranzas, Pagos y Obligaciones** | `receivables`, `payments`, `payment_allocations`, `payment_methods` | Planes de cuotas, cobros recibidos e imputaciones financieras auditadas. |
| **8** | **Operaciones de Caja, Arqueos y Rendiciones** | `cash_sessions`, `cash_movements`, `cash_closings`, `cash_transfers`, `collection_batches`, `collection_settlements` | Apertura de turnos, arqueos ciegos, diferencias, remesas y rendición de recaudadores. |
| **9** | **Comisiones y Liquidaciones Inmutables** | `commission_agreements`, `commission_rules`, `commission_entries`, `commission_allocations`, `commission_statements` | Motor de cálculo versionado, reparto Broker / Productor / Oficina y liquidaciones periódicas. |
| **10** | **Expediente Documental e Integraciones** | `documents`, `document_versions`, `integration_connections`, `webhook_events` | Archivos de pólizas en S3, certificados de cobertura y APIs de aseguradoras. |

---

## 🚀 Guía de Instalación y Puesta en Marcha

### 1. Requisitos Previos
* PHP `^8.3` o `8.5` con extensiones `pdo_mysql`, `mbstring`, `openssl`, `bcmath`, `curl`.
* MySQL 8.0+ / MariaDB.
* Composer 2+.

### 2. Configuración Inicial
```bash
# Instalar dependencias
composer install

# Configurar variables de entorno
cp .env.example .env
php artisan key:generate
```

### 3. Migraciones y Carga de Catálogos
```bash
# Ejecutar migraciones estructurales
php artisan migrate

# Sembrar catálogos (Provincias, Ciudades, Roles, Tipos de Empleado, Tipos de Caja)
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
