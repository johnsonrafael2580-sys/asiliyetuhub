<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public $order,
        public string $status,
        public ?string $message = null,
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Payment update',
            'message' => $this->message ?: "Payment for order #{$this->order->id} is {$this->status}.",
            'order_id' => $this->order->id,
            'payment_status' => $this->status,
        ];
    }
}
