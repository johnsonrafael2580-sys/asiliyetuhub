<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTracking extends Model
{
    use HasFactory;

    protected $table = 'delivery_tracking';
    protected $fillable = [
        'fulfillment_id',
        'event_type',
        'description',
        'location',
        'updated_by',
    ];

   
    public function fulfillment()
    {
        return $this->belongsTo(Fulfillment::class);
    }

   
    public function scopeForFulfillment($query, $fulfillmentId)
    {
        return $query->where('fulfillment_id', $fulfillmentId);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
