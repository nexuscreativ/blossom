<?php

declare(strict_types=1);

namespace App\Enums\Payment;

enum TransactionStatus: string
{
    case PENDING    = 'pending';
    case PROCESSING = 'processing';
    case SUCCESS    = 'success';
    case FAILED     = 'failed';
    case REFUNDED   = 'refunded';
    case CANCELLED  = 'cancelled';

    public function isSuccessful(): bool
    {
        return $this === self::SUCCESS;
    }

    public function isTerminal(): bool
    {
        return in_array($this, [
            self::SUCCESS,
            self::FAILED,
            self::REFUNDED,
            self::CANCELLED,
        ], true);
    }
}
