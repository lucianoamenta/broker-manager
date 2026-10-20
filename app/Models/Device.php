<?php

namespace App\Models;

use App\Http\Middleware\SecureEncryption;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;
use phpseclib3\Crypt\RSA;

class Device extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    const SESION_EN_DEVICE_TIPO_WEB = 'web';

    const SESION_EN_DEVICE_TIPO_API = 'api';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ip_address',
        'last_ip_used',
        'user_agent',
        'type',
        'auth_token',
        'fcm_token',
        'device_platform',
        'device_platform_version',
        'device_sdk',
        'device_brand',
        'device_model',
        'client_public_key',
        'public_key_fingerprint',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Busca el token de Sanctum asociado a esta sesión.
     *
     * @return PersonalAccessToken|null
     */
    public function findSanctumToken()
    {
        // Extraer el ID del token de Sanctum (parte izquierda del '|')
        if (! $this->auth_token) {
            return null;
        }
        $tokenId = explode('|', $this->auth_token)[0];

        // Buscar el token en la tabla personal_access_tokens
        return PersonalAccessToken::find($tokenId);
    }

    /**
     * Guarda la clave pública y calcula su fingerprint
     *
     * @param  string  $publicKey  Clave pública en formato PEM
     *
     * @throws \RuntimeException Si la clave no es válida
     */
    public function savePublicKeyAndFingerprint(string $publicKey): bool
    {
        try {
            // Validar y cargar la clave pública
            $middleware = new SecureEncryption;
            $key = $middleware->loadPublicKeyFromPem($publicKey);

            if (! $key instanceof RSA) {
                throw new \RuntimeException('La clave proporcionada no es una clave RSA válida');
            }

            // Obtener la clave en formato DER
            $derFormat = $key->toString('PKCS8');

            // Calcular fingerprint (SHA-256 del DER)
            $fingerprint = hash('sha256', $derFormat);

            // Actualizar el modelo
            $this->client_public_key = $publicKey;
            $this->public_key_fingerprint = $fingerprint;

            return $this->save();

        } catch (\Exception $e) {
            Log::error("Error al guardar clave pública: {$e->getMessage()}");
            throw new \RuntimeException('Error al procesar la clave pública: '.$e->getMessage());
        }
    }

    /**
     * Verifica si la sesión de este dispositivo sigue vigente.
     */
    public function isActive(): bool
    {
        if ($this->trashed()) {
            return false;
        }
        if ($this->type == self::SESION_EN_DEVICE_TIPO_API) {
            // Para API, verificamos si el token de Sanctum sigue existiendo
            return $this->findSanctumToken() !== null;
        } elseif ($this->type == self::SESION_EN_DEVICE_TIPO_WEB) {
            // Para Web, verificamos si el ID de sesión existe en la tabla 'sessions'
            $sessionId = str_replace('web_session_', '', $this->auth_token);

            return DB::table('sessions')->where('id', $sessionId)->exists();
        }

        return false;
    }
}
