<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppSetting extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_settings';

    protected $fillable = [
        'artisan_id',
        'whatsapp_number',
        'whatsapp_enabled',
        'receive_product_alerts',
        'upload_method',
        'whatsapp_group_link',
    ];

    protected $casts = [
        'whatsapp_enabled' => 'boolean',
        'receive_product_alerts' => 'boolean',
    ];

   
    public function artisan()
    {
        return $this->belongsTo(User::class, 'artisan_id');
    }

    
    public function scopeEnabled($query)
    {
        return $query->where('whatsapp_enabled', true);
    }
}
