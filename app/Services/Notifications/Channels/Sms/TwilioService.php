<?php

namespace App\Services\Notifications\Channels\Sms;

use Twilio\Rest\Client;

class TwilioService
{
    protected Client $client;

    protected string $from;

    protected string $verificationTemplate;

    public function __construct()
    {
        $config = config('services.twilio');

        $this->client = new Client(
            $config['account_sid'],
            $config['auth_token']
        );

        $this->from = $config['from_phone'];
        $this->verificationTemplate = $config['verification_message_template'];
    }

    public function send(string $to, string $message): void
    {
        $this->client->messages->create($to, [
            'from' => $this->from,
            'body' => $message,
        ]);
    }

    public function sendVerificationCode(string $to, string $code): void
    {
        $message = sprintf($this->verificationTemplate, $code);
        $this->send($to, $message);
    }
}
