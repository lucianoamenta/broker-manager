<?php

namespace App\Webhooks;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\WebhookFailed;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;

class MyProjectSignature implements SignatureValidator {
    public function isValid(Request $request, WebhookConfig $config): bool {
        $signature = $request->header($config->signatureHeaderName);
        if (!$signature) {
            return false;
        }
        // Obtén la clave secreta del entorno
        $signingSecret = $config->signingSecret;
        if (empty($signingSecret)) {
            throw WebhookFailed::signingSecretNotSet();
        }

        // Compara la firma recibida con la clave secreta
        return hash_equals($signature, $signingSecret);

        //Esto usarios si quisieramos que vaya no hasheado con sha512
        // $computedSignature = hash_hmac('sha512', $request->getContent(), $signingSecret);
        // return hash_equals($signature, $computedSignature);
    }
}