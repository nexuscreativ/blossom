<?php

namespace App\Models;

use App\Enums\Payment\TransactionStatus;
use App\Enums\Payment\TransactionType;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'subscription_id', 'reference', 'provider', 'type',
        'status', 'amount', 'currency', 'email', 'description',
        'metadata', 'provider_response', 'provider_reference', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => TransactionStatus::class,
            'type' => TransactionType::class,
            'amount' => 'decimal:2',
            'metadata' => 'array',
            'provider_response' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
