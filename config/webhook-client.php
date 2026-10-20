<?php

return [
    'configs' => [
        [
            //Esta configuración es para el webhook de "my-project".
            'name' => 'my-project',
            'signing_secret' => env('MY_PROJECT_WEBHOOK_SECRET_KEY'),
            'signature_header_name' => env('MY_PROJECT_WEBHOOK_SECRET_HEADER'),
            'signature_validator' => App\Webhooks\MyProjectSignature::class,
            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'store_headers' => [],
            'process_webhook_job' => App\Webhooks\ProcessMyProjectWebhook::class,
        ],
    ],

    /*
     * The integer amount of days after which models should be deleted.
     *
     * It deletes all records after 30 days. Set to null if no models should be deleted.
     */
    'delete_after_days' => 30,

    /*
     * Should a unique token be added to the route name
     */
    'add_unique_token_to_route_name' => false,
];
