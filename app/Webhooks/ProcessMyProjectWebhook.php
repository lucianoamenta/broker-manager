<?php

namespace App\Webhooks;


use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessMyProjectWebhook extends ProcessWebhookJob {

    use ApiResponser;

    public function handle() {
        //!INFO: En caso de hacer cambios, debe hacerse restart sobre los queue del servidor/sitio
        
        try {
            Log::info('[PAYLOAD] Webhook recibido', ['payload' => $this->webhookCall->payload]);

            $payload = $this->webhookCall->payload;

            // Normalizar payload si viene envuelto en "payload"
            $data = isset($payload['payload']) ? $payload['payload'] : $payload;

            // Verificar el código de la operación
            // A veces viene 'code', a veces 'type'
            $code = $data['code'] ?? ($data['type'] ?? null);

            if (!$code) {
                Log::warning('[VALIDATION] Payload no tiene código o tipo definido');
                http_response_code(200);
                return;
            }

            if (strtolower($code) === 'codigo_conocido') {
                $this->processCodigoConocido($data);
                Log::info('[WEBHOOK END] Procesamiento de codigo_conocido completado con éxito');
                return $this->successResponse('OK');
            } else {
                Log::warning('[CODE] Tipo de webhook no manejado', ['code' => $code]);
            }

        } catch (\Exception $e) {
            Log::error('[ERROR] Excepción no controlada', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    
        http_response_code(200);
    }

    private function processCodigoConocido(array $data) {
        Log::info('[PROCESSING]');
    }
}