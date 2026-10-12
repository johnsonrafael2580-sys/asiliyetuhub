<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_note',
        'delivery_location',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'escrow_status',
        'platform_reserved_commission',
        'logistics_pool_amount',
        'payment_received_at',
        'payment_verified_at',
        'payment_verified_by',
        'customer_hidden_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'platform_reserved_commission' => 'decimal:2',
        'logistics_pool_amount' => 'decimal:2',
        'payment_received_at' => 'datetime',
        'payment_verified_at' => 'datetime',
        'customer_hidden_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class, 'order_id');
    }

    public function latestPayment()
    {
        return $this->hasOne(OrderPayment::class, 'order_id')->latestOfMany();
    }

    public function isHiddenFromCustomer(): bool
    {
        return !is_null($this->customer_hidden_at);
    }

    public function hideFromCustomer(): void
    {
        $this->update(['customer_hidden_at' => now()]);
    }

    public function restoreForCustomer(): void
    {
        $this->update(['customer_hidden_at' => null]);
    }

    public function canCustomerConfirmDelivery(): bool
    {
        if ($this->payment_status !== 'paid') {
            return false;
        }

        if ($this->escrow_status === 'released_to_artisan') {
            return false;
        }

        $items = $this->items()->get();

        return $items->isNotEmpty()
            && $items->every(fn ($item) => $item->fulfillment_status === 'delivered');
    }

    
    public function syncStatusFromItems(): void
    {
        $statuses = $this->items()->pluck('fulfillment_status')->filter()->values();

        if ($statuses->isEmpty()) {
            return;
        }

        if ($statuses->every(fn ($status) => $status === 'cancelled')) {
            $this->update(['status' => 'cancelled']);
            return;
        }

        if ($statuses->every(fn ($status) => $status === 'delivered')) {
            $this->update(['status' => 'delivered']);
            return;
        }

        if ($statuses->contains(fn ($status) => in_array($status, ['dispatched', 'in_transit', 'out_for_delivery'], true))) {
            $this->update(['status' => 'shipped']);
            return;
        }

        if ($statuses->contains(fn ($status) => in_array($status, ['confirmed', 'packaged', 'processing'], true))) {
            $this->update(['status' => 'processing']);
            return;
        }

        $this->update(['status' => 'pending']);
    }
}
