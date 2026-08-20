<?php

declare(strict_types=1);

namespace App\Enums\Payment;

enum TransactionType: string
{
    case SUBSCRIPTION      = 'subscription';
    case RECURRING_SPLIT   = 'recurring_split';
    case ONE_TIME          = 'one_time';
    case INTERNATIONAL     = 'international';
}
