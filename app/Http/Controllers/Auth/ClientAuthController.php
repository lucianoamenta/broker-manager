<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\DeviceSessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClientAuthController extends Controller
{
    /**
     * Muestra la pantalla de inicio de sesión exclusiva para Clientes Asegurados.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            if ($user->hasRole(User::ROL_CLIENTE)) {
                return redirect()->route('portal.dashboard');
            }
        }

        return view('auth.login');
    }

    /**
     * Procesa la autenticación por correo electrónico para el portal de clientes.
     */
    public function login(Request $request, DeviceSessionService $deviceSessionService): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'Las credenciales ingresadas no coinciden con nuestros registros.']);
        }

        /** @var User $user */
        $user = Auth::user();

        // 1. Verificación de Rol Exclusivo de Cliente
        if (! $user->hasRole(User::ROL_CLIENTE)) {
            Auth::logout();

            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'Acceso denegado. Este portal es exclusivo para clientes y asegurados.']);
        }

        // 2. Verificación de estado de cuenta
        if (! $user->is_allowed) {
            Auth::logout();

            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'Tu cuenta se encuentra temporalmente deshabilitada. Contactá a tu asesor de seguros.']);
        }

        // 3. Control de Dispositivo Único (Regla de negocio: sólo 1 sesión web activa simultánea)
        $deviceSessionService->logoutAllWebDevices($user);
        $deviceSessionService->createWebSession($user, $request);

        $request->session()->regenerate();

        return redirect()->intended(route('portal.dashboard'));
    }

    /**
     * Cierra la sesión activa del cliente e invalida su dispositivo web.
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

        return redirect()->route('login')->with('status', 'Has cerrado tu sesión de forma segura.');
    }
}
