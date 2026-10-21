<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\ClientAuthController;
use App\Http\Controllers\Auth\StaffAuthController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Console\ConsoleDashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page Pública
Route::get('/', function () {
    return view('welcome');
})->name('home');

// -----------------------------------------------------------------------------
// 1. Portal de Clientes (Asegurados)
// -----------------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [ClientAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ClientAuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [ClientAuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:'.User::ROL_CLIENT])->prefix('portal')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('portal.dashboard');
});

// -----------------------------------------------------------------------------
// 2. Consola de Seguridad Ejecutiva (Admin & God)
// -----------------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/auth/security/console/admin', [AdminAuthController::class, 'showLoginForm'])->name('auth.admin.login');
    Route::post('/auth/security/console/admin', [AdminAuthController::class, 'login'])->name('auth.admin.login.submit');
});

Route::post('/auth/security/console/admin/logout', [AdminAuthController::class, 'logout'])->name('auth.admin.logout');

Route::middleware(['auth', 'role:'.User::ROL_ADMIN.'|'.User::ROL_GOD])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// -----------------------------------------------------------------------------
// 3. Consola Operativa y de Sucursales (Cajeros, Recaudadores, Representantes)
// -----------------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/auth/console/login', [StaffAuthController::class, 'showLoginForm'])->name('auth.console.login');
    Route::post('/auth/console/login', [StaffAuthController::class, 'login'])->name('auth.console.login.submit');
});

Route::post('/auth/console/logout', [StaffAuthController::class, 'logout'])->name('auth.console.logout');

Route::middleware('auth')->prefix('console')->name('console.')->group(function () {
    Route::middleware('role:'.User::ROL_CASHIER)->get('/cajero/dashboard', [ConsoleDashboardController::class, 'cashier'])->name('cashier.dashboard');
    Route::middleware('role:'.User::ROL_COLLECTOR)->get('/recaudador/dashboard', [ConsoleDashboardController::class, 'collector'])->name('collector.dashboard');
    Route::middleware('role:'.User::ROL_ADMIN_OFFICE)->get('/oficina/dashboard', [ConsoleDashboardController::class, 'office'])->name('office.dashboard');
    Route::middleware('role:'.User::ROL_ADMIN_ZONE)->get('/zona/dashboard', [ConsoleDashboardController::class, 'zone'])->name('zone.dashboard');
    Route::middleware('role:'.User::ROL_ADMIN_ORGANIZATION)->get('/organizacion/dashboard', [ConsoleDashboardController::class, 'organization'])->name('organization.dashboard');
    Route::get('/departamento/dashboard', [ConsoleDashboardController::class, 'department'])->name('department.dashboard');
});

// -----------------------------------------------------------------------------
// Webhooks
// -----------------------------------------------------------------------------
// !INFO: Don’t forget to run php artisan queue:listen to process the jobs.
Route::webhooks('my-project/webhook', 'my-project');
