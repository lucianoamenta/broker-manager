<?php

namespace App\Services\Notifications;

use App\Models\Notification;
use App\Models\User;
use App\Services\Notifications\Channels\Firebase\FirebaseService;
use App\Services\Notifications\Channels\Mail\MailService;
use App\Services\Notifications\Channels\Sms\TwilioService;
use App\Services\Notifications\DTOs\NotificationData;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class NotificationService
{
    /**
     * Plataformas móviles compatibles para envíos push FCM.
     */
    public const PLATFORM_ANDROID = 'android';

    public const PLATFORM_IOS = 'ios';

    public function __construct(
        protected FirebaseService $firebase,
        protected TwilioService $sms,
        protected MailService $mail,
    ) {}

    /**
     * Crea un registro de notificación en la base de datos y lo envía a los dispositivos del usuario.
     *
     * Nota de Arquitectura: Si el proyecto implementa entidades de negocio adicionales
     * (ej. Client, Employee), pueden pasarse accediendo a su relación $client->user o
     * extendiendo este servicio para destinatarios polimórficos.
     */
    public function notifyUser(User $user, NotificationData $data): ?Notification
    {
        try {
            // 1. Guardar en Base de Datos
            $notification = Notification::create([
                'title' => $data->title,
                'body' => $data->body,
                'description' => $data->description,
                'payload' => $data->payload,
                'event' => $data->event,
                'url_image' => $data->imageUrl,
                'user_id' => $user->id,
                'is_read' => false,
            ]);

            // 2. Enviar Push Notifications
            $this->sendPushToUser($user, $data);

            return $notification;
        } catch (\Throwable $e) {
            Log::error('Error in notifyUser', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Envía una notificación push a todos los dispositivos móviles activos del usuario (Android/iOS).
     */
    public function sendPushToUser(User $user, NotificationData $data): void
    {
        // Obtener dispositivos con token FCM y plataformas móviles compatibles
        $devices = $user->devices()
            ->whereNotNull('fcm_token')
            ->whereIn('device_platform', [self::PLATFORM_ANDROID, self::PLATFORM_IOS])
            ->get();

        if ($devices->isEmpty()) {
            Log::info('No active mobile devices found for push notification', ['user_id' => $user->id]);

            return;
        }

        foreach ($devices as $device) {
            // Solo enviar si la sesión está activa
            if (method_exists($device, 'isActive') && ! $device->isActive()) {
                continue;
            }

            try {
                $this->firebase->send(
                    $device->fcm_token,
                    FirebaseNotification::create($data->title, $data->body),
                    $data->payload
                );

                Log::debug('Push sent successfully', [
                    'device_id' => $device->id,
                    'user_id' => $user->id,
                ]);
            } catch (\Throwable $e) {
                Log::error('Individual push failed', [
                    'device_id' => $device->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /* =====================
     * SMS (Twilio)
     * ===================== */
    public function sendSms(string $phone, string $message): void
    {
        $this->sms->send($phone, $message);
    }

    public function sendSmsVerification(string $phone, string $code): void
    {
        $this->sms->sendVerificationCode($phone, $code);
    }

    /* =====================
     * EMAIL (Mailgun / SMTP)
     * ===================== */
    public function sendEmail(
        string $email,
        string $subject,
        string $view,
        array $data = [],
        array $attachments = [],
        array $rawAttachments = []
    ): void {
        $this->mail->send($email, $subject, $view, $data, $attachments, $rawAttachments);
    }
}
