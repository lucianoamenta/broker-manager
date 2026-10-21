<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\DeviceSessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StaffAuthController extends Controller
{
    /**
     * Muestra la pantalla de acceso a la Consola Operativa y Terminales de Sucursal.
     * Acceso mediante Nombre de Usuario (Username) y Contraseña.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            return $this->redirectBasedOnRole($user);
        }

        return view('auth.staff-login');
    }

    /**
     * Procesa la autenticación por Username y Contraseña para personal operativo,
     * recaudadores, cajeros y representantes de sucursal/zona/organización.
     */
    public function login(Request $request, DeviceSessionService $deviceSessionService): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'El nombre de usuario operativo es requerido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $remember)) {
            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username' => 'Nombre de usuario o contraseña incorrectos.']);
        }

        /** @var User $user */
        $user = Auth::user();

        // 1. Verificación de Roles Operativos Permitidos
        $allowedRoles = [
            User::ROL_CASHIER,
            User::ROL_COLLECTOR,
            User::ROL_ADMIN_OFFICE,
            User::ROL_ADMIN_ZONE,
            User::ROL_ADMIN_ORGANIZATION,
            User::ROL_ADMIN_DEPARTMENT,
            User::ROL_TESORERO_DEPARTMENT,
            User::ROL_ABOGADO_DEPARTMENT,
            User::ROL_EMPLEADO,
        ];

        if (! $user->hasAnyRole($allowedRoles)) {
            Auth::logout();

            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username' => 'Acceso denegado. No posees un rol operativo habilitado para esta consola.']);
        }

        // 2. Verificación de estado de cuenta
        if (! $user->is_allowed) {
            Auth::logout();

            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username' => 'Tu terminal de usuario se encuentra temporalmente inhabilitada.']);
        }

        // 3. Control de Dispositivo Único (Regla de negocio: sólo 1 sesión web activa simultánea)
        $deviceSessionService->logoutAllWebDevices($user);
        $deviceSessionService->createWebSession($user, $request);

        $request->session()->regenerate();

        return $this->redirectBasedOnRole($user);
    }

    /**
     * Redirige inteligentemente al panel correspondiente según el rol del usuario operativo.
     */
    protected function redirectBasedOnRole(User $user): RedirectResponse
    {
        if ($user->hasRole(User::ROL_CASHIER)) {
            return redirect()->intended(route('console.cashier.dashboard'));
        }

        if ($user->hasRole(User::ROL_COLLECTOR)) {
            return redirect()->intended(route('console.collector.dashboard'));
        }

        if ($user->hasRole(User::ROL_ADMIN_OFFICE)) {
            return redirect()->intended(route('console.office.dashboard'));
        }

        if ($user->hasRole(User::ROL_ADMIN_ZONE)) {
            return redirect()->intended(route('console.zone.dashboard'));
        }

        if ($user->hasRole(User::ROL_ADMIN_ORGANIZATION)) {
            return redirect()->intended(route('console.organization.dashboard'));
        }

        return redirect()->intended(route('console.department.dashboard'));
    }

    /**
     * Cierra la sesión del personal operativo e invalida su dispositivo.
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

        return redirect()->route('auth.console.login')->with('status', 'Sesión de terminal cerrada exitosamente.');
    }
}
