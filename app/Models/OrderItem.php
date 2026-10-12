<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'artisan_id',
        'product_id',
        'product_title',
        'product_description',
        'price',
        'quantity',
        'subtotal',
        'base_product_price',
        'shipping_fee_per_item',
        'platform_commission',
        'artisan_earnings',
        'payment_status',
        'payment_settled_at',
        'fulfillment_status',
    ];

    protected $casts = [
        'payment_settled_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function artisan()
    {
        return $this->belongsTo(User::class, 'artisan_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productRequest()
    {
        return $this->hasOne(ProductRequest::class, 'order_item_id');
    }
}
