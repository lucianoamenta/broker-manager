<?php

namespace App\Services\Auth;

use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceSessionService
{
    /**
     * Crea una nueva sesión API (Token Sanctum + Registro de Dispositivo)
     */
    public function createApiSession(User $user, Request $request, string $tokenName = 'Auth Token'): array
    {
        $token = $user->createToken($tokenName)->plainTextToken;

        $device = Device::create([
            'user_id' => $user->id,
            'type' => Device::SESION_EN_DEVICE_TIPO_API,
            'ip_address' => $request->ip(),
            'last_ip_used' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'auth_token' => $token,
            // Aquí puedes mapear dinámicamente si te envían headers como app-version, platform, etc.
        ]);

        $this->limitSessionHistory($user);

        return [
            'token' => $token,
            'device_id' => (string) $device->id,
        ];
    }

    /**
     * Crea un registro de auditoría para la sesión Web actual
     */
    public function createWebSession(User $user, Request $request): array
    {
        $authToken = 'web_session_'.session()->getId();

        $device = Device::create([
            'user_id' => $user->id,
            'type' => Device::SESION_EN_DEVICE_TIPO_WEB,
            'ip_address' => $request->ip(),
            'last_ip_used' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'auth_token' => $authToken,
        ]);

        $this->limitSessionHistory($user);

        return [
            'token' => $authToken,
            'device_id' => (string) $device->id,
        ];
    }

    /**
     * Termina ABSOLUTAMENTE TODAS las sesiones (Web y API) de un usuario
     */
    public function logoutAllDevices(User $user, ?string $keepWebSessionId = null): void
    {
        $this->logoutAllApiDevices($user);
        $this->logoutAllWebDevices($user, $keepWebSessionId);
    }

    /**
     * Termina SÓLO las sesiones API (Tokens Sanctum)
     */
    public function logoutAllApiDevices(User $user): void
    {
        // 1. Invalidar los tokens de acceso reales
        $user->tokens()->delete();

        // 2. Limpiar el historial de esos dispositivos móviles
        $user->devices()->where('type', Device::SESION_EN_DEVICE_TIPO_API)->delete();
    }

    /**
     * Termina SÓLO las sesiones Web (Panel Ikerpay)
     * Puede preservar la sesión actual si se envía su ID.
     */
    public function logoutAllWebDevices(User $user, ?string $keepSessionId = null): void
    {
        // 1. Borrar de la tabla de sesiones de Laravel para expulsarlos realmente
        $query = DB::table('sessions')->where('user_id', $user->id);
        if ($keepSessionId) {
            $query->where('id', '!=', $keepSessionId);
        }
        $query->delete();

        // 2. Limpiar nuestro registro visual de auditoría (Devices tipo web)
        $devicesQuery = $user->devices()->where('type', 'web');
        if ($keepSessionId) {
            $devicesQuery->where('auth_token', '!=', 'web_session_'.$keepSessionId);
        }
        $devicesQuery->delete();
    }

    /**
     * Termina una sesión/dispositivo específico (Ej. cuando el admin aprieta "Desconectar este equipo")
     */
    public function logoutDevice(string $authToken): void
    {
        $device = Device::where('auth_token', $authToken)->first();

        if (! $device) {
            return;
        }

        if ($device->type == Device::SESION_EN_DEVICE_TIPO_API) {
            // Expulsar el token real de sanctum
            $sanctumToken = $device->findSanctumToken();
            if ($sanctumToken) {
                $sanctumToken->delete();
            }
        } elseif ($device->type == Device::SESION_EN_DEVICE_TIPO_WEB) {
            // Expulsar la cookie web de la tabla
            $sessionId = str_replace('web_session_', '', $device->auth_token);
            DB::table('sessions')->where('id', $sessionId)->delete();
        }

        // Borrar nuestro registro de auditoría
        $device->delete();
    }

    /**
     * Limita el historial de sesiones cerradas/inactivas para el usuario.
     * Mantiene un máximo de 10 sesiones cerradas/inactivas, eliminando físicamente las más antiguas.
     */
    protected function limitSessionHistory(User $user): void
    {
        $devices = Device::withTrashed()
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        $activeCount = 0;
        $inactiveCount = 0;

        foreach ($devices as $device) {
            if ($device->isActive()) {
                $activeCount++;
            } else {
                $inactiveCount++;
                if ($inactiveCount > 10) {
                    $device->forceDelete();
                }
            }
        }
    }
}
