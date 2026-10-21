<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\DeviceSessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    /**
     * Muestra la pantalla de acceso a la Consola Ejecutiva de Seguridad (Admin & GOD).
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            if ($user->hasAnyRole([User::ROL_GOD, User::ROL_ADMIN])) {
                return redirect()->route('admin.dashboard');
            }
        }

        return view('auth.admin-login');
    }

    /**
     * Procesa la autenticación de directivos y administradores.
     */
    public function login(Request $request, DeviceSessionService $deviceSessionService): RedirectResponse
    {
        $input = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'El correo electrónico o usuario es requerido.',
            'password.required' => 'La clave de seguridad es obligatoria.',
        ]);

        $loginField = filter_var($input['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginField => $input['login'],
            'password' => $input['password'],
        ];

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('login', 'remember'))
                ->withErrors(['login' => 'Credenciales administrativas inválidas.']);
        }

        /** @var User $user */
        $user = Auth::user();

        // 1. Verificación de roles ejecutivos (Admin o God)
        if (! $user->hasAnyRole([User::ROL_GOD, User::ROL_ADMIN])) {
            Auth::logout();

            return back()
                ->withInput($request->only('login', 'remember'))
                ->withErrors(['login' => 'Acceso denegado. Se requieren credenciales de Administrador o Superadmin (GOD).']);
        }

        // 2. Verificación de estado de cuenta
        if (! $user->is_allowed) {
            Auth::logout();

            return back()
                ->withInput($request->only('login', 'remember'))
                ->withErrors(['login' => 'La cuenta administrativa se encuentra suspendida o deshabilitada.']);
        }

        // 3. Control de Dispositivo Único (Regla de negocio: sólo 1 sesión web activa simultánea)
        $deviceSessionService->logoutAllWebDevices($user);
        $deviceSessionService->createWebSession($user, $request);

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Cierra la sesión ejecutiva y retorna al portal de consola de seguridad.
     */
    public function logout(Request $request, DeviceSessionService $deviceSessionService): RedirectResponse
    {
        /** @var User|null $user */
        $user = Auth::user();

        if ($user) {
            $deviceSessionService->logoutDevice('web_session_'.session()->getId());
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.admin.login')->with('status', 'Sesión administrativa cerrada correctamente.');
    }
}
