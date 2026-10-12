<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppMessage extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_messages';

    protected $fillable = [
        'artisan_id',
        'product_id',
        'message_type',
        'phone_number',
        'message_content',
        'status',
        'whatsapp_message_id',
        'error_details',
        'sent_at',
        'delivered_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    
    public function artisan()
    {
        return $this->belongsTo(User::class, 'artisan_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

   
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }
}
