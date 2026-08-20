<?php

declare(strict_types=1);

namespace App\Enums\Payment;

enum PaymentProvider: string
{
    case PAYSTACK = 'paystack';
    case NOMBA   = 'nomba';
    case MONNIFY = 'monnify';

    public function displayName(): string
    {
        return match ($this) {
            self::PAYSTACK => 'Paystack',
            self::NOMBA    => 'Nomba (OPay)',
            self::MONNIFY  => 'Monnify (Moniepoint)',
        };
    }

    public function supportsSubscriptions(): bool
    {
        return match ($this) {
            self::PAYSTACK => true,
            self::NOMBA    => false,
            self::MONNIFY  => true,
        };
    }

    public function supportsSplits(): bool
    {
        return match ($this) {
            self::PAYSTACK => true,
            self::NOMBA    => false,
            self::MONNIFY  => true,
        };
    }
}
