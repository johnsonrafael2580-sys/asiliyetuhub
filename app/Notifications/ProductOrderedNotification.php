<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductOrderedNotification extends Notification
{
    use Queueable;

    public $order;
    public $orderItem;

    public function __construct($order, $orderItem)
    {
        $this->order = $order;
        $this->orderItem = $orderItem;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New order received',
            'message' => "You have a new order (#{$this->order->id}) for '{$this->orderItem->product_title}' (Qty: {$this->orderItem->quantity}).",
            'order_id' => $this->order->id,
            'product_id' => $this->orderItem->product_id,
            'order_item_id' => $this->orderItem->id,
        ];
    }
}
