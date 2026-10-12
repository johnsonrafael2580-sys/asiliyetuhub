<?php

namespace App\Services;

use App\Mail\NotificationMail;
use App\Models\WhatsAppMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CustomerCommunicationService
{
    public function send(?string $email, ?string $phone, string $subject, string $message, array $context = []): void
    {
        if ($email) {
            try {
                Mail::to($email)->send(new NotificationMail([
                    'title' => $subject,
                    'message' => $message,
                    ...$context,
                ]));
            } catch (\Throwable $e) {
                Log::warning('Automatic email notification failed', ['email' => $email, 'error' => $e->getMessage()]);
            }
        }

        if ($phone && config('services.whatsapp.api_key') && config('services.whatsapp.api_url')) {
            try {
                $response = Http::timeout(20)
                    ->withToken(config('services.whatsapp.api_key'))
                    ->post(rtrim(config('services.whatsapp.api_url'), '/') . '/send', [
                        'phone' => $phone,
                        'body' => $message,
                    ]);

                if ($response->failed()) {
                    throw new \RuntimeException('WhatsApp provider HTTP ' . $response->status());
                }

                WhatsAppMessage::create([
                    'phone_number' => $phone,
                    'message_content' => $message,
                    'message_type' => 'automatic_order_update',
                    'status' => 'sent',
                    'whatsapp_message_id' => $response->json('id'),
                    'sent_at' => now(),
                ]);
            } catch (\Throwable $e) {
                Log::warning('Automatic WhatsApp notification failed', ['phone' => $phone, 'error' => $e->getMessage()]);
            }
        }
    }
}
