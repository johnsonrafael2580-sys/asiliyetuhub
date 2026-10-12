<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fulfillment extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_request_id',
        'artisan_id',
        'status',
        'tracking_number',
        'courier_partner',
        'packaging_notes',
        'pickup_location',
        'delivery_location',
        'special_instructions',
        'packaged_at',
        'dispatched_at',
        'delivered_at',
    ];

    protected $casts = [
        'packaged_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

   
    public function productRequest()
    {
        return $this->belongsTo(ProductRequest::class);
    }

    public function artisan()
    {
        return $this->belongsTo(User::class, 'artisan_id');
    }

    public function deliveryTracking()
    {
        return $this->hasMany(DeliveryTracking::class);
    }

   
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInTransit($query)
    {
        return $query->where('status', 'in_transit');
    }
}
