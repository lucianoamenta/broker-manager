<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class Audit extends Model
{
    // 🔹 EVENTO PARA USUARIOS
    const EVENT_USER_CREATED = 'user_created';

    const EVENT_USER_DATA_UPDATED = 'user_data_updated';

    // 🔹 Lista de eventos válidos (para validación y autocompletado)
    public static function validEvents(): array
    {
        return [
            self::EVENT_USER_CREATED,
            self::EVENT_USER_DATA_UPDATED,
        ];
    }

    /**
     * Devuelve los estilos y nombres amigables de los eventos válidos.
     */
    public static function eventDetails(): array
    {
        return [
            self::EVENT_USER_CREATED => [
                'label' => 'Creación de Usuario',
                'color' => '#38bdf8',
                'bg' => 'rgba(56, 189, 248, 0.15)',
                'border' => 'rgba(56, 189, 248, 0.3)',
                'icon' => 'user-shield',
            ],
            self::EVENT_USER_DATA_UPDATED => [
                'label' => 'Datos Modificados de un Usuario',
                'color' => '#60a5fa',
                'bg' => 'rgba(96, 165, 250, 0.15)',
                'border' => 'rgba(96, 165, 250, 0.3)',
                'icon' => 'user-plus',
            ],
        ];
    }

    /**
     * Obtiene los detalles de un evento específico o un valor por defecto si no existe.
     */
    public static function getEventDetails(string $event): array
    {
        $details = self::eventDetails();

        return $details[$event] ?? [
            'label' => str_replace('_', ' ', $event),
            'color' => '#cbd5e1',
            'bg' => 'rgba(203, 213, 225, 0.1)',
            'border' => 'rgba(203, 213, 225, 0.2)',
            'icon' => 'info-circle',
        ];
    }

    protected $fillable = [
        'user_id',
        'subject_type',
        'subject_id',
        'event',
        'description',
        'changes',
        'metadata',
    ];

    protected $casts = [
        'changes' => 'array',
        'metadata' => 'array',
    ];

    /**
     * Registra una acción en la tabla de auditoría.
     *
     * @param  string  $event  Nombre de la acción (ej: 'transfer_created', 'email_updated')
     * @param  array  $data  Datos opcionales: subject, changes, metadata, user_id
     */
    public static function log(string $event, array $data = []): self
    {
        // 🔐 Validación: solo permitir eventos definidos
        if (! in_array($event, self::validEvents())) {
            throw new InvalidArgumentException("Evento de auditoría inválido: '$event'. Usa una constante de la clase Audit.");
        }
        // Valores por defecto
        $userId = $data['user_id'] ?? auth()->id(); // usuario logueado (puede ser null)

        // 🔐 Filtro GOD: si el ejecutor de la acción es un usuario GOD (rol o tipo de empleado), no guardar nada
        if ($userId) {
            $userObj = User::with(['employee.employeeType', 'roles'])->find($userId);
            if ($userObj) {
                $isGod = $userObj->hasRole(User::ROL_GOD) ||
                         ($userObj->employee && $userObj->employee->employeeType && $userObj->employee->employeeType->code === 'god');
                if ($isGod) {
                    return new self;
                }
            }
        }

        // Extraer subject (modelo afectado, opcional)
        $subjectType = isset($data['subject']) ? get_class($data['subject']) : null;
        $subjectId = isset($data['subject']) ? (string) $data['subject']->getKey() : null;

        // Metadatos automáticos: IP, método, URL
        $defaultMeta = [
            'ip' => request()?->ip(),
            'method' => request()?->method(),
            'url' => request()?->fullUrl(),
            'user_agent' => request()?->userAgent(),
        ];
        $metadata = array_merge($defaultMeta, $data['metadata'] ?? []);

        return self::create([
            'user_id' => $userId,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'event' => $event,
            'description' => $data['description'] ?? null,
            'changes' => $data['changes'] ?? null,
            'metadata' => $metadata,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }

    // EJEMPLO DE COMO GUARDAR UNA AUDITORIA
    // Audit::log(Audit::EVENT_TRANSFER_CREATED, [
    //     'subject' => $transfer,
    //     'changes' => [
    //         'amount' => [null, $transfer->amount],
    //         'cbu' => [null, $transfer->other_person_cbu],
    //     ],
    //     'metadata' => [
    //         'reason' => 'Extracción de dinero por app móvil',
    //     ],
    // ]);

    // OTRO EJEMPLO
    // Audit::log(Audit::EVENT_USER_EMAIL_CHANGED, [
    //     'subject' => $user,
    //     'changes' => [
    //         'email' => [$oldEmail, $request->email],
    //     ],
    // ]);

    // OTRO EJEMPLO CREADO POR EL SISTEMA Y NO POR UN USUARIO
    // En un Job, Command o Observer:
    // Audit::log(Audit::EVENT_SYSTEM_CLIENT_AUTO_VERIFIED, [
    //     'subject' => $client,
    //     'user_id' => null,
    //     'metadata' => [
    //         'reason' => 'Verificación por DNI + selfie match = 98%',
    //     ],
    // ]);
}
