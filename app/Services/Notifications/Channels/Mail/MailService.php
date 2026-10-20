<?php

namespace App\Services\Notifications\Channels\Mail;

use Illuminate\Support\Facades\Mail;

class MailService
{
    public function send(
        string $to,
        string $subject,
        string $view,
        array $data = [],
        array $attachments = [],
        array $rawAttachments = []
    ): void {
        Mail::send($view, $data, function ($message) use ($to, $subject, $attachments, $rawAttachments) {
            $message->to($to)->subject($subject);

            foreach ($attachments as $attachment) {
                $message->attach($attachment);
            }

            foreach ($rawAttachments as $raw) {
                $message->attachData($raw['data'], $raw['name'], $raw['options'] ?? []);
            }
        });
    }
}
