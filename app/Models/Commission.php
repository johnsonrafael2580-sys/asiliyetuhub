<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'artisan_id',
        'order_id',
        'product_id',
        'order_amount',
        'commission_rate',
        'commission_amount',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'order_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
    ];

    
    public function artisan()
    {
        return $this->belongsTo(User::class, 'artisan_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
       
        return $this->belongsTo(ProductRequest::class, 'order_id');
    }

    public function newOrder()
    {
        
        return $this->belongsTo(Order::class, 'order_id');
    }

   
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForArtisan($query, $artisanId)
    {
        return $query->where('artisan_id', $artisanId);
    }
}
