<?php

declare(strict_types=1);

namespace App\Enums\Payment;

enum SubscriptionStatus: string
{
    case ACTIVE          = 'active';
    case PAST_DUE        = 'past_due';
    case CANCELLED       = 'cancelled';
    case EXPIRED         = 'expired';
    case PAUSED          = 'paused';
    case TRIAL           = 'trial';
    case NON_RENEWING    = 'non_renewing';

    public function isActive(): bool
    {
        return in_array($this, [self::ACTIVE, self::TRIAL], true);
    }

    public function grantsAccess(): bool
    {
        return $this->isActive() || $this === self::NON_RENEWING;
    }
}
