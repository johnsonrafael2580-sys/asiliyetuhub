<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = [
        'order_id',
        'customer_id',
        'agent_key',
        'agent_name',
        'payment_method',
        'amount',
        'sender_phone',
        'transaction_id',
        'checkout_request_id',
        'provider_transaction_id',
        'provider_status',
        'provider_response',
        'proof_path',
        'status',
        'rejection_reason',
        'verified_by',
        'submitted_at',
        'verified_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
        'provider_response' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}