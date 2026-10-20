<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

/*
|--------------------------------------------------------------------------
| 🌐 API Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas de la API del sistema. Por defecto, todas están
| prefijadas con '/api' y estructuradas por versionamiento (v1, v2...).
|
| Arquitectura de capas recomendada:
| 1. Rutas Públicas (Health check, Catálogos generales sin auth).
| 2. Rutas de Autenticación (Login, Registro, Recuperación de contraseña).
| 3. Rutas Protegidas Globales ('auth:sanctum', 'update.device.ip').
| 4. Subgrupos protegidos por Rol ('role:client', 'role:admin', 'role:employee').
|
*/

// --------------------------------------------------------------------------
// 🩺 Health Check & System Status
// --------------------------------------------------------------------------
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
        'framework' => 'Laravel 13',
    ]);
});

// --------------------------------------------------------------------------
// 📦 Versión 1 (v1)
// --------------------------------------------------------------------------
Route::prefix('v1')->group(function () {

    // ----------------------------------------------------------------------
    // 🌍 Catálogos y Datos Públicos (Solo lectura, con rate limiting)
    // ----------------------------------------------------------------------
    Route::prefix('catalogs')->middleware('throttle:60,1')->group(function () {
        // Ejemplo de endpoints de catálogos:
        // Route::get('/provinces', [CityController::class, 'index']);
        // Route::get('/genders', [GenderController::class, 'index']);
    });

    // ----------------------------------------------------------------------
    // 🔐 Autenticación y Onboarding (Público con Throttle estricto)
    // ----------------------------------------------------------------------
    Route::prefix('auth')->middleware('throttle:60,1')->group(function () {
        // Ejemplo de endpoints de acceso:
        // Route::post('/login', [AuthController::class, 'login']);
        // Route::post('/signup', [AuthController::class, 'signup']);
        // Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    });

    // ----------------------------------------------------------------------
    // 🛡️ Rutas Autenticadas (Requieren Token Sanctum y Validación de Dispositivo/IP)
    // ----------------------------------------------------------------------
    Route::middleware(['auth:sanctum', 'update.device.ip'])->group(function () {

        // Perfil y Sesión del Usuario Autenticado
        Route::get('/me', function (Request $request) {
            return response()->json([
                'success' => true,
                'data' => $request->user(),
            ]);
        });

        // ------------------------------------------------------------------
        // 👥 Rutas para Clientes (Rol: client)
        // ------------------------------------------------------------------
        Route::prefix('clients')
            ->middleware(RoleMiddleware::class.':'.User::ROL_CLIENTE)
            ->group(function () {
                // Endpoints específicos para clientes...
            });

        // ------------------------------------------------------------------
        // 👔 Rutas para Empleados / Operadores (Rol: employee)
        // ------------------------------------------------------------------
        Route::prefix('employees')
            ->middleware(RoleMiddleware::class.':'.User::ROL_EMPLEADO)
            ->group(function () {
                // Endpoints para gestión de empleados...
            });

        // ------------------------------------------------------------------
        // ⚡ Rutas Administrativas (Rol: admin o god)
        // ------------------------------------------------------------------
        Route::prefix('admin')
            ->middleware(RoleMiddleware::class.':'.User::ROL_ADMIN)
            ->group(function () {
                // Endpoints de administración de plataforma...
            });
    });
});
