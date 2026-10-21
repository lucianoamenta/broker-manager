<?php

use App\Http\Middlewares\UpdateDeviceIp;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->validateCsrfTokens(except: [
            'my-project/webhook', // Excluir webhook del proyecto de la protección CSRF
        ]);
        $middleware->alias([
            'update.device.ip' => UpdateDeviceIp::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
        $middleware->redirectTo(
            guests: function (Request $request) {
                if (! $request->expectsJson()) {
                    session()->flash('error', 'Debes iniciar sesión para acceder al sistema.');
                    if ($request->is('admin*') || $request->is('auth/security/console/admin*')) {
                        return route('auth.admin.login');
                    }
                    if ($request->is('console*') || $request->is('auth/console*')) {
                        return route('auth.console.login');
                    }

                    return route('login');
                }

                return null;
            },
            users: function (Request $request) {
                $user = $request->user();
                if (! $user) {
                    return route('home');
                }
                if ($user->hasAnyRole([User::ROL_GOD, User::ROL_ADMIN])) {
                    return route('admin.dashboard');
                }
                if ($user->hasRole(User::ROL_CLIENTE)) {
                    return route('portal.dashboard');
                }
                if ($user->hasRole(User::ROL_CASHIER)) {
                    return route('console.cashier.dashboard');
                }
                if ($user->hasRole(User::ROL_COLLECTOR)) {
                    return route('console.collector.dashboard');
                }
                if ($user->hasRole(User::ROL_ADMIN_OFFICE)) {
                    return route('console.office.dashboard');
                }
                if ($user->hasRole(User::ROL_ADMIN_ZONE)) {
                    return route('console.zone.dashboard');
                }
                if ($user->hasRole(User::ROL_ADMIN_ORGANIZATION)) {
                    return route('console.organization.dashboard');
                }

                return route('console.department.dashboard');
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
