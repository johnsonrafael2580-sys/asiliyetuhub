<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'base_price',
        'shipping_fee',
        'stock_quantity',
        'story',
        'category',
        'image_path',
        'is_available',
        'platform_commission_rate',
    ];

    public function artisan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function getAverageRatingAttribute()
    {
        $avg = $this->reviews()->avg('rating');
        return $avg ? number_format($avg, 1) : '0.0';
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    
    public function getPlatformCommissionAttribute(): float
    {
        $basePrice = $this->base_price ?? $this->price;
        return ($basePrice * 10) / 100;
    }

    
    public function getArtisanEarningsAttribute(): float
    {
        $basePrice = $this->base_price ?? $this->price;
        return $basePrice - $this->platform_commission;
    }

   
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    
    public function getStockStatusAttribute(): string
    {
        $stock = max(0, (int) $this->stock_quantity);

        if ($stock <= 0) {
            return 'Out of Stock';
        }

        if ($stock <= 3) {
            return 'Only ' . $stock . ' left';
        }

        if ($stock <= 10) {
            return 'Low stock: ' . $stock . ' available';
        }

        return 'In stock: ' . $stock . ' available';
    }
}
