<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductRequestedNotification extends Notification
{
    use Queueable;

    public $productRequest;

    public function __construct($productRequest)
    {
        $this->productRequest = $productRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New product request',
            'message' => "{$this->productRequest->customer_name} requested '{$this->productRequest->product->title}'",
            'product_request_id' => $this->productRequest->id,
            'product_id' => $this->productRequest->product_id,
        ];
    }
}
