<?php

namespace App\Models;

use App\Enums\Payment\SubscriptionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'plan', 'status', 'amount', 'currency', 'provider',
        'provider_subscription_id', 'provider_plan_code', 'starts_at',
        'ends_at', 'trial_ends_at', 'cancelled_at', 'last_payment_at',
        'next_payment_at', 'payments_count',
    ];

    protected function casts(): array
    {
        return [
            'status' => SubscriptionStatus::class,
            'amount' => 'decimal:2',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'trial_ends_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'last_payment_at' => 'datetime',
            'next_payment_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->status->isActive() && $this->ends_at->isFuture();
    }

    public function daysUntilExpiry(): int
    {
        return (int) now()->diffInDays($this->ends_at, false);
    }
}
