<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middlewares\UpdateDeviceIp;
use Illuminate\Http\Request;

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
            // 'role.admin' => DashboardAdminMiddleware::class,
            // 'role.god_admin' => \App\Http\Middleware\DashboardGodAdminMiddleware::class,
            // 'role.client' => \App\Http\Middleware\DashboardClientMiddleware::class,
        ]);
        $middleware->redirectTo(
            guests: function (\Illuminate\Http\Request $request) {
                if (!$request->expectsJson()) {
                    session()->flash('error', 'No te encuentras autenticado en el sistema. Debes iniciar sesión para acceder.');
                    return route('dashboard.client.login');
                }
                return null;
            },
            users: '/dashboard/overview'
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
