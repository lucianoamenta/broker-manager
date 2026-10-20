<?php

namespace App\Services\Notifications\DTOs;

class NotificationData
{
    /**
     * @param  string  $title  Título de la notificación push
     * @param  string  $body  Cuerpo del mensaje
     * @param  array|null  $payload  Datos extras para la App (transaction_id, type, etc)
     * @param  string|null  $imageUrl  URL de imagen opcional
     * @param  string|null  $event  Tipo de evento (transfer, news, etc)
     * @param  string|null  $description  Descripción interna opcional
     */
    public function __construct(
        public readonly string $title,
        public readonly string $body,
        public readonly ?array $payload = null,
        public readonly ?string $imageUrl = null,
        public readonly ?string $event = null,
        public readonly ?string $description = null,
    ) {}
}
