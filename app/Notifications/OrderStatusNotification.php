<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
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
            'title' => 'Order status updated',
            'message' => $this->message ?: "Order #{$this->order->id} status is now " . str_replace('_', ' ', $this->status) . '.',
            'order_id' => $this->order->id,
            'status' => $this->status,
        ];
    }
}
