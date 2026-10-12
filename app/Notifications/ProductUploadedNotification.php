<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ProductUploadedNotification extends Notification
{
    use Queueable;

    public $product;

    
    public function __construct($product)
    {
        $this->product = $product;
    }

   
    public function via($notifiable)
    {
        return ['database'];
    }

   
    public function toArray($notifiable)
    {
        return [
            'title' => 'Product uploaded',
            'message' => "Your product '{$this->product->title}' was uploaded successfully.",
            'product_id' => $this->product->id,
        ];
    }
}
