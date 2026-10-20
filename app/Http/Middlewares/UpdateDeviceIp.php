<?php

namespace App\Http\Middlewares;

use App\Models\Device;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class UpdateDeviceIp
{
    public function handle(Request $request, Closure $next)
    {
        // Obtener el token de la solicitud
        $token = $request->bearerToken();

        if ($token) {
            // Buscar el token en Sanctum
            $sanctumToken = PersonalAccessToken::findToken($token);

            if ($sanctumToken) {
                $user = $sanctumToken->tokenable;

                // Verificar si el usuario está habilitado y tiene persona activa
                $shouldInvalidate = false;

                // 1. Verificar estado del usuario
                if (! $user->estaHabilitado()) {
                    $shouldInvalidate = true;
                }

                // 2. Verificar que el usuario esté verificado
                if (! $user->esVerificado()) {
                    $shouldInvalidate = true;
                }

                // 3a. Verificar estado del cliente asociado
                if ($user->client) {
                    if (! $user->client->is_active) {
                        $shouldInvalidate = true;
                    }
                }

                // Si alguna condición falla, invalidar sesiones
                if ($shouldInvalidate) {
                    // Eliminar todos los tokens del usuario (físicamente)
                    $user->tokens()->delete();

                    // Eliminar todas las sesiones (soft delete)
                    $user->devices()->delete();

                    return response()->json([
                        'error' => 'account_not_active',
                        'message' => 'Your account is not active',
                    ], 403);
                }

                // Buscar el dispositivo asociado al token
                $device = Device::where('auth_token', $token)->first();
                if ($device && $device->last_ip_used !== $request->ip()) {
                    // Actualizar la última IP usada SOLO si cambió
                    $device->last_ip_used = $request->ip();
                    $device->updated_at = now();
                    $device->save();
                }
            }
        }

        return $next($request);
    }
}
