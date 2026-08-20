<?php

namespace App\Services\Payment;

use App\Enums\Payment\PaymentProvider;
use App\Enums\Payment\TransactionStatus;
use App\Enums\Payment\TransactionType;
use App\ValueObjects\Money;

interface PaymentGatewayInterface
{
    public function getProvider(): PaymentProvider;

    public function initializePayment(
        string $email,
        Money $amount,
        string $reference,
        string $description,
        array $metadata = []
    ): array;

    public function verifyPayment(string $reference): array;

    public function initializeSubscription(
        string $email,
        Money $amount,
        string $reference,
        string $planCode,
        array $metadata = []
    ): array;

    public function createSubaccount(
        string $businessName,
        string $bankCode,
        string $accountNumber,
        float $percentageCharge
    ): array;

    public function createTransferRecipient(
        string $name,
        string $bankCode,
        string $accountNumber
    ): array;

    public function initiateTransfer(
        string $recipientCode,
        Money $amount,
        string $reference
    ): array;
}
