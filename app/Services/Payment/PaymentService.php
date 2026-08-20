<?php

namespace App\Services\Payment;

use App\Enums\Payment\PaymentProvider;
use App\Enums\Payment\TransactionStatus;
use App\Enums\Payment\TransactionType;
use App\Models\Transaction;
use App\ValueObjects\Money;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected array $gateways = [];
    protected PaymentProvider $defaultProvider;

    public function __construct()
    {
        $this->defaultProvider = PaymentProvider::from(config('blossom.payments.default', 'paystack'));
    }

    public function registerGateway(PaymentGatewayInterface $gateway): void
    {
        $this->gateways[$gateway->getProvider()->value] = $gateway;
    }

    public function getGateway(?PaymentProvider $provider = null): PaymentGatewayInterface
    {
        $provider = $provider ?? $this->defaultProvider;
        $key = $provider->value;

        if (!isset($this->gateways[$key])) {
            throw new \RuntimeException("Payment gateway [{$key}] is not registered.");
        }

        return $this->gateways[$key];
    }

    /**
     * Initialize payment with automatic fallback.
     * Tries primary provider first, falls back to alternatives on failure.
     */
    public function initializePayment(
        string $email,
        Money $amount,
        string $reference,
        string $description,
        TransactionType $type,
        array $metadata = [],
        ?PaymentProvider $preferredProvider = null,
        ?int $userId = null,
    ): array {
        $providers = $this->getProviderFallbackOrder($preferredProvider);
        $lastException = null;

        foreach ($providers as $provider) {
            try {
                $gateway = $this->getGateway($provider);
                $result = $gateway->initializePayment($email, $amount, $reference, $description, $metadata);

                if (isset($result['authorization_url'])) {
                    $this->recordTransaction($reference, $provider, $type, $amount, $email, $userId);
                    return $result;
                }
            } catch (\Exception $e) {
                $lastException = $e;
                Log::warning("Payment provider [{$provider->value}] failed for reference [{$reference}]: " . $e->getMessage());
                continue;
            }
        }

        throw new \RuntimeException(
            'All payment providers failed. Last error: ' . ($lastException?->getMessage() ?? 'Unknown')
        );
    }

    /**
     * Verify payment across providers.
     */
    public function verifyPayment(string $reference, ?PaymentProvider $provider = null): array
    {
        $providers = $provider ? [$provider] : array_values(PaymentProvider::cases());

        foreach ($providers as $prov) {
            try {
                $gateway = $this->getGateway($prov);
                $result = $gateway->verifyPayment($reference);

                if (isset($result['status']) && in_array($result['status'], ['success', 'completed', 'paid'])) {
                    $this->markTransactionSuccess($reference, $result);
                    return $result;
                }
            } catch (\Exception $e) {
                Log::warning("Verification failed for [{$prov->value}] reference [{$reference}]: " . $e->getMessage());
                continue;
            }
        }

        return ['status' => 'failed', 'message' => 'Payment could not be verified.'];
    }

    public function initializeSubscription(
        string $email,
        Money $amount,
        string $reference,
        string $planCode,
        array $metadata = [],
        ?PaymentProvider $preferredProvider = null,
        ?int $userId = null,
    ): array {
        $providers = $this->getProviderFallbackOrder($preferredProvider);
        $lastException = null;

        foreach ($providers as $provider) {
            try {
                $gateway = $this->getGateway($provider);
                $result = $gateway->initializeSubscription($email, $amount, $reference, $planCode, $metadata);

                if (isset($result['authorization_url'])) {
                    $this->recordTransaction($reference, $provider, TransactionType::SUBSCRIPTION, $amount, $email, $userId);
                    return $result;
                }
            } catch (\Exception $e) {
                $lastException = $e;
                Log::warning("Subscription provider [{$provider->value}] failed: " . $e->getMessage());
                continue;
            }
        }

        throw new \RuntimeException(
            'All subscription providers failed. Last error: ' . ($lastException?->getMessage() ?? 'Unknown')
        );
    }

    /**
     * Activate a pending subscription after successful payment verification.
     * Used by both callback controller and webhook handler.
     *
     * Runs inside a database transaction and locks the transaction row so
     * concurrent webhook + callback calls can never double-activate (C5).
     */
    public function activateSubscriptionForUser(int $userId, string $reference, array $paymentResult): void
    {
        DB::transaction(function () use ($userId, $reference, $paymentResult) {
            $transaction = Transaction::where('reference', $reference)
                ->lockForUpdate()
                ->first();

            if (!$transaction) {
                Log::warning('No transaction found for activation', ['reference' => $reference]);
                return;
            }

            if ($transaction->status->isSuccessful()) {
                Log::info('Transaction already processed', ['reference' => $reference]);
                return;
            }

            // Mark transaction as successful (idempotent claim)
            $transaction->update([
                'status' => TransactionStatus::SUCCESS,
                'provider_response' => $paymentResult,
                'paid_at' => now(),
            ]);

            // Find or create subscription
            $metadata = $transaction->metadata ?? [];
            $selectedPlan = $metadata['selected_plan'] ?? $this->guessPlanFromAmount($transaction->amount);

            $subscription = \App\Models\Subscription::where('user_id', $userId)
                ->where('status', 'pending')
                ->where('plan', $selectedPlan)
                ->latest()
                ->first();

            if ($subscription) {
                // Activate existing pending subscription
                $subscription->update([
                    'status' => \App\Enums\Payment\SubscriptionStatus::ACTIVE,
                    'provider' => $transaction->provider->value,
                    'provider_subscription_id' => $paymentResult['subscription_code']
                        ?? $paymentResult['transaction_reference']
                        ?? $paymentResult['order_no']
                        ?? null,
                    'starts_at' => now(),
                    'ends_at' => $selectedPlan === 'yearly' ? now()->addYear() : now()->addMonth(),
                    'last_payment_at' => now(),
                    'next_payment_at' => $selectedPlan === 'yearly' ? now()->addYear() : now()->addMonth(),
                    'payments_count' => 1,
                ]);

                $transaction->update(['subscription_id' => $subscription->id]);
            } else {
                // Create new subscription (fallback for webhook-only flows)
                $endsAt = $selectedPlan === 'yearly' ? now()->addYear() : now()->addMonth();

                // Cancel any existing active subscription
                \App\Models\Subscription::where('user_id', $userId)
                    ->where('status', \App\Enums\Payment\SubscriptionStatus::ACTIVE)
                    ->update([
                        'status' => \App\Enums\Payment\SubscriptionStatus::CANCELLED,
                        'cancelled_at' => now(),
                    ]);

                $subscription = \App\Models\Subscription::create([
                    'user_id' => $userId,
                    'plan' => $selectedPlan,
                    'status' => \App\Enums\Payment\SubscriptionStatus::ACTIVE,
                    'amount' => $transaction->amount, // stored in kobo, same unit as transactions (C6)
                    'currency' => 'NGN',
                    'provider' => $transaction->provider->value,
                    'provider_subscription_id' => $paymentResult['subscription_code'] ?? null,
                    'starts_at' => now(),
                    'ends_at' => $endsAt,
                    'last_payment_at' => now(),
                    'next_payment_at' => $endsAt,
                    'payments_count' => 1,
                ]);

                $transaction->update(['subscription_id' => $subscription->id]);
            }

            Log::info('Subscription activated', [
                'user_id' => $userId,
                'plan' => $selectedPlan,
                'reference' => $reference,
            ]);
        });
    }

    protected function getProviderFallbackOrder(?PaymentProvider $preferred = null): array
    {
        $all = array_values(PaymentProvider::cases());

        if ($preferred) {
            $others = array_filter($all, fn($p) => $p !== $preferred);
            array_unshift($others, $preferred);
            return array_values($others);
        }

        return $all;
    }

    protected function recordTransaction(
        string $reference,
        PaymentProvider $provider,
        TransactionType $type,
        Money $amount,
        string $email,
        ?int $userId = null,
    ): void {
        Transaction::create([
            'reference' => $reference,
            'user_id' => $userId,
            'provider' => $provider,
            'type' => $type,
            'status' => TransactionStatus::PENDING,
            'amount' => $amount->toInt(),
            'currency' => $amount->currency(),
            'email' => $email,
        ]);
    }

    protected function markTransactionSuccess(string $reference, array $result): void
    {
        DB::transaction(function () use ($reference, $result) {
            Transaction::where('reference', $reference)
                ->where('status', TransactionStatus::PENDING)
                ->lockForUpdate()
                ->update([
                    'status' => TransactionStatus::SUCCESS,
                    'provider_response' => $result,
                    'paid_at' => now(),
                ]);
        });
    }

    private function guessPlanFromAmount(int $amountKobo): string
    {
        $plans = config('blossom.subscriptions.plans', ['monthly' => 2500, 'yearly' => 20000]);

        return collect($plans)
            ->filter(fn (int $naira) => $naira * 100 === $amountKobo)
            ->keys()
            ->first() ?? 'monthly';
    }
}
