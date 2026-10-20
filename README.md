# 🚀 Laravel Base Boilerplate

> **Plataforma base empresarial en Laravel 13**, diseñada con estándares de arquitectura limpia, alta escalabilidad y buenas prácticas de ingeniería de software. Preparada para aplicaciones web modernas, arquitecturas SPA y servicios API RESTful robustos con control de sesiones por dispositivo, seguridad perimetral por UUID, doble capa de autorización (RBAC + Tipos de Empleado), trazabilidad por auditoría, almacenamiento distribuido en S3, procesamiento seguro de Webhooks, notificaciones multicanal (Firebase, Twilio, Mailgun) y programación automática de mantenimiento.

---

## 📌 Tabla de Contenidos

- [Visión y Arquitectura](#-visión-y-arquitectura)
- [Stack Tecnológico y Versiones](#-stack-tecnológico-y-versiones)
- [Configuración Central del Framework (bootstrap/app.php)](#-configuración-central-del-framework-bootstrapappphp)
- [Arquitectura de Rutas API (routes/api.php)](#-arquitectura-de-rutas-api-routesapiphp)
    - [Estrategia de Versionamiento y Throttling](#estrategia-de-versionamiento-y-throttling)
    - [Capas de Protección (Auth Sanctum + UpdateDeviceIp + RBAC)](#capas-de-protección-auth-sanctum--updatedeviceip--rbac)
    - [Respuestas Homogéneas (ApiResponser y ApiController)](#respuestas-homogéneas-apiresponser-y-apicontroller)
- [Capa de Modelos, Seguridad y Usuarios](#-capa-de-modelos-seguridad-y-usuarios)
    - [Modelo User y Roles Centrales](#modelo-user-y-roles-centrales)
    - [Seguridad Perimetral: Traits HasUuid y FindsByIdOrUuid](#seguridad-perimetral-traits-hasuuid-y-findsbyidoruuid)
    - [Gestión de Sesiones, Dispositivos y Middleware UpdateDeviceIp](#gestión-de-sesiones-dispositivos-y-middleware-updatedeviceip)
    - [Sistema de Auditoría Flexible (Audit)](#sistema-de-auditoría-flexible-audit)
    - [Personal Interno: Empleados y Tipos de Empleado](#personal-interno-empleados-y-tipos-de-empleado)
- [Catálogos Base del Sistema](#-catálogos-base-del-sistema)
    - [Trait HasCode para Catálogos](#trait-hascode-para-catálogos)
    - [Geografía: Provincias y Ciudades Argentinas](#geografía-provincias-y-ciudades-argentinas)
    - [Datos Personales, Fiscales y Laborales](#datos-personales-fiscales-y-laborales)
- [Capa de Almacenamiento en la Nube (S3Service)](#-capa-de-almacenamiento-en-la-nube-s3service)
    - [Discos s3 y s3_backups (config/filesystems.php)](#discos-s3-y-s3_backups-configfilesystemsphp)
    - [Value Object StoredFile y Subida Base64](#value-object-storedfile-y-subida-base64)
- [Respaldo Automatizado del Sistema (Spatie Backup)](#-respaldo-automatizado-del-sistema-spatie-backup)
- [Seguridad y Políticas CORS (config/cors.php)](#-seguridad-y-políticas-cors-configcorsphp)
- [Recepción y Procesamiento de Webhooks (Spatie Webhook Client)](#-recepción-y-procesamiento-de-webhooks-spatie-webhook-client)
- [Capa de Notificaciones Multicanal (NotificationService)](#-capa-de-notificaciones-multicanal-notificationservice)
    - [Canales Integrados: Push (Firebase), SMS (Twilio) y Email (Mailgun)](#canales-integrados-push-firebase-sms-twilio-y-email-mailgun)
    - [Seguridad de Credenciales Privadas (storage/app)](#seguridad-de-credenciales-privadas-storageapp)
- [Comandos de Consola y Scheduler (routes/console.php)](#-comandos-de-consola-y-scheduler-routesconsolephp)
- [Sistema de Comentarios Inteligentes (.dev-comments.md)](#-sistema-de-comentarios-inteligentes-dev-commentsmd)
- [Variables de Entorno y Configuración (.env)](#-variables-de-entorno-y-configuración-env)
- [Guía de Instalación y Puesta en Marcha](#-guía-de-instalación-y-puesta-en-marcha)
- [Personalización para un Nuevo Proyecto](#-personalización-para-un-nuevo-proyecto)
- [Siembra de Datos (Seeders)](#-siembra-de-datos-seeders)
- [Comandos de Desarrollo y Calidad](#-comandos-de-desarrollo-y-calidad)

---

## 🏛 Visión y Arquitectura

El propósito de este **Boilerplate Base** es eliminar toda fricción técnica en nuevos desarrollos empresariales, proporcionando una estructura probada en producción con:

1. **Seguridad y Privacidad por Diseño (Security by Design):**
    - **Claves Primarias Híbridas:** Claves numéricas internas para rendimiento e indexación rápida, y **UUID v4 públicos** para APIs y URLs mediante `HasUuid`, evitando ataques de enumeración (IDOR).
    - **Búsqueda Polimórfica Segura:** Mediante `FindsByIdOrUuid`, cualquier endpoint o servicio puede aceptar un ID numérico o un UUID indistintamente.
    - **Control de Sesiones por Dispositivo:** Trazabilidad estricta de IP (`last_ip_used`) y dispositivo, con expulsión inmediata (HTTP 403) ante usuarios inhabilitados o no verificados.
    - **Doble Capa de Acceso:** Roles y permisos de Spatie en `User` (RBAC) combinados con `EmployeeType` para la estructura jerárquica interna.
2. **Arquitectura Desacoplada y Servicios Orientados a Dominio:**
    - Servicios dedicados en `app/Services/` (`Storage`, `Notifications`, `Auth`), tipados fuertemente con DTOs y Value Objects inmutables.
    - Procesamiento de Webhooks asíncrono en segundo plano mediante colas de Laravel.
3. **Resiliencia Operativa y Trazabilidad:**
    - Respaldos diarios de BD y archivos hacia S3, exclusión de carpetas volátiles y alertas automáticas por correo.
    - Auditoría granular (`audits`) con diferencias JSON antes/después y metadatos de red.

---

## 🛠 Stack Tecnológico y Versiones

| Tecnología / Componente          | Versión / Restricción      | Propósito en la Arquitectura                                    |
| :------------------------------- | :------------------------- | :-------------------------------------------------------------- |
| **PHP**                          | `^8.3` (Entorno: `8.5.x`)  | Lenguaje base con tipado estricto y alto rendimiento            |
| **Laravel Framework**            | `13.35.0` (Core: `^13.17`) | Framework web modular con arquitectura moderna                  |
| **Laravel Sanctum**              | `v4.3.3` (`^4.3`)          | Autenticación ligera mediante tokens personales y SPA           |
| **Spatie Laravel Permission**    | `v8.3.0` (`^8.3`)          | Control de acceso basado en roles y permisos (RBAC)             |
| **Spatie Laravel Backup**        | `v10.3.3` (`^10.3`)        | Respaldo automatizado de BD y archivos hacia S3                 |
| **Spatie Webhook Client**        | `v3.7.0` (`^3.7`)          | Recepción segura, validación de firma y jobs para Webhooks      |
| **Kreait Laravel Firebase**      | `v7.2.1` (`^7.2`)          | SDK oficial para Notificaciones Push (FCM)                      |
| **League Flysystem AWS S3**      | `v3.35.3` (`^3.0`)         | Driver para almacenamiento de objetos en AWS S3 / Cloudflare R2 |
| **Twilio SDK**                   | `v8.13.0` (`^8.13`)        | Envío de notificaciones SMS, WhatsApp y códigos 2FA             |
| **Symfony Mailgun Mailer**       | `v8.1.6` (`^8.1`)          | Driver de transporte de correos para Mailgun API                |
| **Symfony HTTP Client & Guzzle** | `v8.1.8` / `v8.2.0`        | Clientes HTTP optimizados para integraciones externas           |
| **Barryvdh Laravel Debugbar**    | `v4.4.4` (`^4.4` - dev)    | Profiler y barra de depuración en entorno local                 |
| **Laravel Pint**                 | `v1.32.1` (`^1.27` - dev)  | Linter y formateador de código bajo estándar PSR-12 / Laravel   |
| **PHPUnit**                      | `v12.5.39` (`^12.5` - dev) | Suite de pruebas automatizadas (Unitarias y Feature)            |

---

## ⚙️ Configuración Central del Framework (bootstrap/app.php)

En Laravel 13, la configuración de rutas, middlewares y excepciones se centraliza en [bootstrap/app.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/bootstrap/app.php):

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',        // Registro nativo de rutas API
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');      // Confiabilidad en proxies (Forge, Cloudflare, AWS ALB)
        $middleware->validateCsrfTokens(except: [
            'my-project/webhook',                 // Excluye webhooks de protección CSRF
        ]);
        $middleware->alias([
            'update.device.ip' => UpdateDeviceIp::class,
        ]);
        $middleware->redirectTo(
            guests: function (Request $request) {
                if (!$request->expectsJson()) {
                    session()->flash('error', 'Debes iniciar sesión para acceder.');
                    return route('dashboard.client.login');
                }
                return null;
            },
            users: '/dashboard/overview'
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Garantiza que cualquier error en la API retorne JSON estandarizado
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
```

---

## 🌐 Arquitectura de Rutas API (routes/api.php)

El archivo [routes/api.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/routes/api.php) está estructurado bajo las mejores prácticas de la industria:

```text
/api/health                     (Público - Health check del sistema)
/api/v1/
   ├── catalogs/               (Público - Throttle 60/min - Provincias, Genders, etc.)
   ├── auth/                   (Público - Throttle 60/min - Login, Signup, Forgot Password)
   └── [auth:sanctum + update.device.ip]  (Protegido Global)
         ├── /me               (Perfil de usuario autenticado)
         ├── /clients/         (Rol: client - Panel de clientes)
         ├── /employees/       (Rol: employee - Operadores internos)
         └── /admin/           (Rol: admin - Gestión general del sistema)
```

### Estrategia de Versionamiento y Throttling

1. **Versionamiento Explícito (`/v1`, `/v2`):** Permite evolucionar los contratos de la API sin romper clientes móviles antiguos ni integraciones activas.
2. **Rate Limiting Granular (`throttle`):**
    - **Catálogos y Consultas Generales:** `throttle:60,1` (60 peticiones/minuto).
    - **Operaciones Críticas o Financieras:** `throttle:30,1` (30 peticiones/minuto).
    - **Confirmaciones de Seguridad (PIN, OTP, SMS):** `throttle:20,1` (20 peticiones/minuto) para mitigar fuerza bruta.

### Capas de Protección (Auth Sanctum + UpdateDeviceIp + RBAC)

Cualquier endpoint privado se encapsula en una doble barrera:

- `auth:sanctum`: Verifica la validez y expiración del token Bearer.
- `update.device.ip`: Verifica en tiempo real si el usuario sigue habilitado y verificado, y actualiza la última IP usada.
- `RoleMiddleware::class.':'.User::ROL_*`: Restringe el acceso exclusivamente a los roles autorizados (clientes, operadores o administradores).

### Respuestas Homogéneas (ApiResponser y ApiController)

Para evitar respuestas caóticas o formatos dispares entre controladores, se incluye el trait [app/Traits/ApiResponser.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Traits/ApiResponser.php) y el controlador base [app/Http/Controllers/ApiController.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Http/Controllers/ApiController.php):

```php
// Respuesta exitosa:
return $this->successResponse('Operación completada', ['user' => $user]);

// Respuesta de error:
return $this->errorResponse('Recurso no disponible', 404);

// Paginación y caché de respuestas:
return $this->showAllPaginate($collection);
return $this->cacheRequest(fn() => $this->showAll($items), minutes: 5);
```

Estructura JSON garantizada:

```json
{
  "status": true,
  "code": 200,
  "message": "Operación completada",
  "data": { ... }
}
```

---

## 👤 Capa de Modelos, Seguridad y Usuarios

### Modelo User y Roles Centrales

[app/Models/User.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Models/User.php) combina las capacidades centrales:

- `HasApiTokens`: Emisión y revocación de tokens personales (Sanctum).
- `HasRoles`: Gestión de roles y permisos (Spatie Permission).
- `HasUuid`: Generación automática de UUID v4 en la creación.
- `SoftDeletes`: Borrado lógico para preservar integridad histórica y auditorías.
- `Notifiable`: Envío de notificaciones nativas de Laravel.

#### Constantes de Roles Base

```php
const ROL_GOD      = 'god';       // Superadministrador total del sistema
const ROL_ADMIN    = 'admin';     // Administrador general de la plataforma
const ROL_EMPLEADO = 'employee';  // Personal interno operativo
const ROL_CLIENTE  = 'client';    // Usuario o cliente final
const ROL_BOT      = 'bot';       // Proceso automatizado / integración de servicio
```

---

### Seguridad Perimetral: Traits HasUuid y FindsByIdOrUuid

- **`HasUuid` ([app/Traits/HasUuid.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Traits/HasUuid.php)):** Inyecta automáticamente un UUID v4 (`Str::uuid()`) en el evento Eloquent `creating`.
- **`FindsByIdOrUuid` ([app/Traits/FindsByIdOrUuid.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Traits/FindsByIdOrUuid.php)):** Provee el scope `findByIdOrUuid($id)`. Si `$id` es numérico busca por `id`; si es alfanumérico busca por `uuid`.

---

### Gestión de Sesiones, Dispositivos y Middleware UpdateDeviceIp

El middleware [app/Http/Middlewares/UpdateDeviceIp.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Http/Middlewares/UpdateDeviceIp.php) y el servicio [app/Services/Auth/DeviceSessionService.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Services/Auth/DeviceSessionService.php) auditan y controlan el acceso:

- **Expulsión en Caliente:** Si el usuario es deshabilitado (`! $user->estaHabilitado()`) o no verificado (`! $user->esVerificado()`), revoca de inmediato todos los tokens de Sanctum y cierra sus sesiones de dispositivo con HTTP 403 `account_not_active`.
- **Trazabilidad de IP:** Solo escribe en base de datos si la IP entrante es diferente a `last_ip_used`.
- **Limpieza Automática:** `limitSessionHistory()` mantiene un máximo de 10 sesiones inactivas y purga las antiguas con `forceDelete()`.

---

### Sistema de Auditoría Flexible (Audit)

[app/Models/Audit.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Models/Audit.php) permite registrar acciones de usuarios o eventos de fondo:

- `user_id`: Quién ejecutó la acción.
- `subject_type` & `subject_id`: Entidad polimórfica afectada (ej. `User`, `Employee`).
- `event`: Clave estandarizada (`user_created`, `user_data_updated`).
- `description`: Texto explicativo.
- `changes`: JSON con valores anteriores y posteriores.
- `metadata`: JSON con IP, User-Agent y contexto.

---

### Personal Interno: Empleados y Tipos de Empleado

La migración `2026_10_13_000200_create_employees_table.php` desacopla la cuenta de acceso (`users`) del legajo del personal ([Employee](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Models/Employee.php)):

- `employee_types`: Catálogo con `TYPE_GOD`, `TYPE_ADMIN`, `TYPE_OPERATOR`, `TYPE_BOT`.
- Doble control: Spatie define los permisos en el sistema; `EmployeeType` define la función jerárquica en la empresa.

---

## 🗂 Catálogos Base del Sistema

### Trait HasCode para Catálogos

Ubicado en [app/Models/Traits/HasCode.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Models/Traits/HasCode.php), habilita búsquedas insensibles a mayúsculas/minúsculas (`findByCode('cf')`, `isValidCode('male')`), exponiendo códigos semánticos a las APIs en lugar de IDs internos de base de datos.

### Geografía y Tablas Maestras

- **Provincias y Ciudades:** Cargadas en su totalidad por [CitiesTableSeeder.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/database/seeders/CitiesTableSeeder.php) (código de jurisdicción y códigos postales).
- **Catálogos Demográficos:** Estados civiles, géneros, actividades comerciales (23 rubros), condiciones fiscales ARCA/AFIP y tipos de empleado sembrados por [CatalogSeeder.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/database/seeders/CatalogSeeder.php).

---

## ☁️ Capa de Almacenamiento en la Nube (S3Service)

### Discos s3 y s3_backups (config/filesystems.php)

El archivo [config/filesystems.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/config/filesystems.php) define dos discos S3 independientes:

1. `'s3'`: Para archivos generales de la aplicación (imágenes de perfil, documentos, comprobantes).
2. `'s3_backups'`: Disco dedicado con `'root' => 'backups'`, aislando los archivos ZIP de respaldo del resto de los datos del bucket.

### Value Object StoredFile y Subida Base64

[app/Services/Storage/S3Service.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Services/Storage/S3Service.php) retorna instancias inmutables de [StoredFile](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Services/Storage/ValueObjects/StoredFile.php):

- Soporta tanto `UploadedFile` (multipart) como cadenas `Base64` / Data URIs vía `uploadFromBase64()`.
- Captura errores bajo la excepción tipada `S3UploadException`.

---

## 💾 Respaldo Automatizado del Sistema (Spatie Backup)

Configurado en [config/backup.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/config/backup.php):

- **Destino:** Almacena en el disco `s3_backups`.
- **Nomenclatura:** Prefijo con fecha y hora: `backup_YYYY-mm-dd_HH-ii-ss_`.
- **Exclusiones Críticas:** No respalda archivos volátiles ni cachés:
    - `storage/debugbar`, `storage/logs`, `storage/framework/*`, `bootstrap/cache`, `vendor`, `node_modules`.
- **Notificaciones:** Envía reportes por correo (`BACKUP_MAIL_TO_ADDRESS`, `BACKUP_MAIL_FROM_ADDRESS`).

---

## 🔒 Seguridad y Políticas CORS (config/cors.php)

Configurado en [config/cors.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/config/cors.php):

- **Rutas permitidas:** `api/*` y `sanctum/csrf-cookie`.
- **Exclusión explícita de Webhooks:** `!my-project/webhook` (los webhooks server-to-server no requieren preflight de navegador).
- **Headers autorizados:** `Authorization`, `z-key-type`, `X-Client-Type`, `X-Mobile-App-Key`, `X-Postman-Key`, `X-Request-Encrypted`, `X-Client-Public-Key`, etc.
- **Headers expuestos:** `Authorization`, `X-RateLimit-Remaining`, `X-Response-Encrypted`.
- **Orígenes dinámicos:** Configurable en `.env` mediante `ALLOWED_ORIGINS=https://tu-app.com,https://admin.tu-app.com`.

---

## 🪝 Recepción y Procesamiento de Webhooks (Spatie Webhook Client)

El paquete `spatie/laravel-webhook-client` recibe eventos externos garantizando idempotencia y seguridad:

```text
[Servicio Externo] ──(POST /my-project/webhook con firma)──► Laravel Route
                                                                   │
                                                                   ▼
                                                       [MyProjectSignature Validator]
                                                       (Verifica Header con Clave Secreta)
                                                                   │
                                                                   ▼
                                                       [Tabla webhook_calls]
                                                       (Guarda Payload en BD)
                                                                   │
                                                                   ▼
                                                       [ProcessMyProjectWebhook Job]
                                                       (Procesa en Cola Asíncrona)
```

1. **Ruta:** Registrada en [routes/web.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/routes/web.php):
    ```php
    Route::webhooks('my-project/webhook', 'my-project');
    ```
2. **Validación de Firma:** [app/Webhooks/MyProjectSignature.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Webhooks/MyProjectSignature.php) valida la cabecera secreta (`MY_PROJECT_WEBHOOK_SECRET_KEY`).
3. **Job Asíncrono:** [app/Webhooks/ProcessMyProjectWebhook.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Webhooks/ProcessMyProjectWebhook.php) ejecuta la lógica de negocio en segundo plano.

---

## 🔔 Capa de Notificaciones Multicanal (NotificationService)

El servicio [app/Services/Notifications/NotificationService.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Services/Notifications/NotificationService.php) unifica tres canales corporativos:

1. **Push Notifications (Firebase Cloud Messaging - FCM):**
    - Usa el SDK oficial de Google mediante `kreait/laravel-firebase`.
    - Envía a los dispositivos activos (`Device`) del usuario con token FCM (`PLATFORM_ANDROID`, `PLATFORM_IOS`).
2. **SMS y Verificación 2FA (Twilio):**
    - Envío de mensajes de texto y códigos de verificación (`sendSms`, `sendSmsVerification`).
3. **Correo Transaccional (Mailgun / SMTP):**
    - Envío de emails con plantillas Blade y archivos adjuntos (`sendEmail`).

### Seguridad de Credenciales Privadas (storage/app)

> [!CAUTION]
> El archivo JSON de credenciales de Firebase (`service-account.json`) o certificados privados **NUNCA** deben subirse a Git. Deben almacenarse dentro de `storage/app/credentials/` y referenciarse en el `.env` mediante su ruta absoluta o relativa:
>
> ```env
> FIREBASE_CREDENTIALS=storage/app/credentials/firebase.json
> ```

---

## 🖥️ Comandos de Consola y Scheduler (routes/console.php)

El archivo [routes/console.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/routes/console.php) orquesta las tareas de mantenimiento periódicas:

```php
// Backups automáticos en S3 (Spatie)
Schedule::command('backup:run')->daily()->at('03:00')->onOneServer();
Schedule::command('backup:clean')->daily()->at('01:00')->onOneServer();

// Mantenimiento de sesiones y dispositivos obsoletos
Schedule::command('system:cleanup-sessions')->weekly()->at('04:00')->onOneServer();
```

### Comando Personalizado `system:cleanup-sessions`

Ubicado en [app/Console/Commands/CleanupSessions.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/app/Console/Commands/CleanupSessions.php):

1. Ejecuta `sanctum:prune-expired --hours=24` para purgar tokens de API expirados.
2. Elimina sesiones web vencidas de la tabla `sessions`.
3. Aplica borrado lógico (`delete()`) a dispositivos con sesiones inactivas.
4. Aplica borrado físico permanente (`forceDelete()`) a dispositivos eliminados hace más de 7 días.

#### Configuración en Servidor de Producción (Cron / Laravel Forge)

Configurar una única tarea en el crontab del servidor:

```bash
* * * * * cd /ruta/al/proyecto && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🏷️ Sistema de Comentarios Inteligentes (.dev-comments.md)

El archivo [.dev-comments.md](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/.dev-comments.md) documenta el estándar de notas en el código para extensiones como **Better Comments** y **Todo Tree**:

- `//!TODO`: Tareas pendientes.
- `//!FIXME`: Código a reparar.
- `//!WARNING`: Advertencias de lógica sensible.
- `//!SECURITY`: Puntos críticos de autenticación o cifrado.
- `//!INFO` / `//!NOTE`: Aclaraciones arquitectónicas y de configuración.

---

## 🔑 Variables de Entorno y Configuración (.env)

El archivo [.env.example](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/.env.example) incluye la plantilla completa con todas las secciones del boilerplate:

- **Base de Datos & Sesiones:** `DB_*`, `SESSION_DRIVER=database`, `QUEUE_CONNECTION=database` / `redis`.
- **AWS S3 & Backups:** `AWS_*`, `BACKUP_MAIL_*`.
- **Mailgun & Twilio:** `MAILGUN_*`, `TWILIO_*`.
- **Firebase:** `FIREBASE_CREDENTIALS`.
- **Seguridad & CORS:** `ALLOWED_ORIGINS`, `POSTMAN_API_KEYS`, `MOBILE_APP_API_KEYS`.
- **Webhooks e Integraciones:** `MY_PROJECT_WEBHOOK_*`, `OTHER_PROJECT_*`.

> [!TIP]
> Al configurar credenciales en `config/services.php`, la aplicación puede compilar y congelar su configuración en producción mediante `php artisan config:cache` para máximo rendimiento.

---

## 🚀 Guía de Instalación y Puesta en Marcha

Para levantar el proyecto en un entorno local o de un nuevo colaborador:

### 1. Clonar el Repositorio

```bash
git clone https://github.com/lucianoamenta/laravel-boilerplate.git mi-proyecto
cd mi-proyecto
```

### 2. Instalar Dependencias PHP

```bash
composer install
```

### 3. Configurar Variables de Entorno

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Preparar la Base de Datos (MySQL)

Asegúrate de que el servicio MySQL esté corriendo y crea la base de datos correspondiente:

```bash
# Crear base de datos en MySQL local o servidor
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS laravel_boilerplate CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Configura en tu `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_boilerplate
DB_USERNAME=root
DB_PASSWORD=tu_password
```

### 5. Ejecutar Migraciones y Seeders

```bash
# Correr todas las migraciones del sistema
php artisan migrate

# Sembrar provincias, ciudades argentinas, roles base y catálogos
php artisan db:seed
```

### 6. Iniciar Servidor Local de Desarrollo

```bash
php artisan serve
```

La aplicación estará disponible en `http://127.0.0.1:8000`.

---

## 🛠️ Personalización para un Nuevo Proyecto

Cuando utilices este repositorio como plantilla para iniciar un producto nuevo (por ejemplo, **"Ferretería Pepito"**), sigue esta lista de cambios recomendados para desvincularlo de la base genérica y adaptar su identidad:

### 1. Variables de Entorno y Branding (`.env`)

Actualiza los nombres comerciales, dominios y base de datos:

```env
# Identidad de la Aplicación
APP_NAME="Ferretería Pepito"
APP_URL=http://localhost:8000

# Base de Datos Propia
DB_DATABASE=ferreteria_pepito

# Correo y Notificaciones Comerciales
MAIL_FROM_NAME="Ferretería Pepito"
MAIL_FROM_ADDRESS="no-reply@ferreteriapepito.com"

# Sistema de Backups
BACKUP_MAIL_FROM_NAME="Ferretería Pepito"
BACKUP_MAIL_TO_ADDRESS="admin@ferreteriapepito.com"

# Almacenamiento en S3 (Buckets propios de la empresa)
AWS_BUCKET=ferreteria-pepito-assets

# Orígenes Permitidos para Frontends / Apps
ALLOWED_ORIGINS=http://localhost:3000,https://app.ferreteriapepito.com
```

> **Crear la base de datos en MySQL antes de migrar:**
>
> ```bash
> mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS ferreteria_pepito CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
> ```

### 2. Nombre del Paquete (`composer.json`)

Modifica la clave `"name"` y `"description"` para reflejar el nuevo repositorio:

```json
{
    "name": "pepito/ferreteria-core",
    "description": "Backend API para la plataforma Ferretería Pepito",
    ...
}
```

### 3. Rutas y Claves de Webhooks (`config/webhook-client.php`)

Si el nuevo proyecto recibe webhooks de una pasarela o sistema externo propio:

- En [config/webhook-client.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/config/webhook-client.php), ajusta el `'name'` (ej. `'pepito-webhook'`).
- En [routes/web.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/routes/web.php), actualiza la ruta del webhook:
    ```php
    Route::webhooks('api/webhooks/pepito', 'pepito-webhook');
    ```
- En [bootstrap/app.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/bootstrap/app.php), ajusta la excepción de validación CSRF para que coincida con la nueva URL del webhook.

### 4. Desvincular de Git y Conectar al Nuevo Repositorio

Para comenzar el historial limpio del nuevo proyecto:

```bash
# Eliminar el origen del boilerplate
git remote remove origin

# Enlazar con el nuevo repositorio de la empresa/cliente
git remote add origin https://github.com/tu-empresa/ferreteria-pepito.git

# Subir la rama principal
git branch -M main
git push -u origin main
```

---

## 📦 Siembra de Datos (Seeders)

[DatabaseSeeder.php](file:///Users/lucianoamenta/Documents/Laravel/laravel-base-boilerplate/database/seeders/DatabaseSeeder.php) ejecuta en orden:

1. **`CitiesTableSeeder`:** Carga las 24 provincias argentinas y sus ciudades completas con CP.
2. **`RolesTableSeeder`:** Crea los roles base (`god`, `admin`, `employee`, `client`, `bot`) y permisos iniciales.
3. **`CatalogSeeder`:** Siembra estados civiles, géneros, actividades comerciales, condiciones fiscales y tipos de empleado.

---

## 🧪 Comandos de Desarrollo y Calidad

### Formateo y Estilo de Código (Pint)

```bash
vendor/bin/pint --dirty   # Archivos modificados
vendor/bin/pint           # Proyecto completo
```

### Ejecución de Pruebas Automatizadas

```bash
php artisan test
```

### Inspección de Rutas

```bash
php artisan route:list --except-vendor
```

---

<p align="center">
  <b>Laravel Base Boilerplate</b> • Arquitectura limpia y base lista para producción.
</p>
