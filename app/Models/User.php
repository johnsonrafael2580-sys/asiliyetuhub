<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

   
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'password',
        'location',
        'latitude',
        'longitude',
        'wallet_balance',
        'is_approved',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
            'wallet_balance' => 'decimal:2',
        ];
    }

   
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'artisan_id');
    }

    
    public function commissions()
    {
        return $this->hasMany(Commission::class, 'artisan_id');
    }

    public function whatsappSettings()
    {
        return $this->hasOne(WhatsAppSetting::class, 'artisan_id');
    }

    public function whatsappMessages()
    {
        return $this->hasMany(WhatsAppMessage::class, 'artisan_id');
    }

   
    public function getAvailableBalanceAttribute()
    {
        return $this->commissions()->where('status', 'completed')->sum('commission_amount');
    }

    public function getPendingEarningsAttribute()
    {
        return $this->commissions()->where('status', 'pending')->sum('commission_amount');
    }
}
