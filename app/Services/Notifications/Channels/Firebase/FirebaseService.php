<?php

namespace App\Services\Notifications\Channels\Firebase;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('services.firebase.credentials'));

        $this->messaging = $factory->createMessaging();
    }

    /**
     * Envía una notificación Cloud Message a Firebase.
     *
     * @param  string  $token  FCM Token del dispositivo
     * @param  Notification  $notification  Objeto de notificación (Título/Cuerpo)
     * @param  array|null  $data  Payload extra (debe ser un array plano de strings para mejor compatibilidad)
     */
    public function send(
        string $token,
        Notification $notification,
        ?array $data = null
    ): void {
        try {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification);

            if ($data) {
                // Firebase requiere que todos los valores en 'data' sean strings
                $formattedData = array_map(fn ($val) => (string) $val, $data);
                $message = $message->withData($formattedData);
            }

            $this->messaging->send($message);

        } catch (\Throwable $e) {
            Log::error('Firebase notification delivery failed', [
                'token' => substr($token, 0, 10).'...',
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
