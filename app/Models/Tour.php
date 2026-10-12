<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'location',
        'description',
        'price_per_person',
        'image_path',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}