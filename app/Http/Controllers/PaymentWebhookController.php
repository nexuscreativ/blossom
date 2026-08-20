<?php

namespace App\Http\Controllers;

use App\Enums\Payment\PaymentProvider;
use App\Enums\Payment\TransactionStatus;
use App\Enums\Payment\SubscriptionStatus;
use App\Models\Transaction;
use App\Models\Subscription;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    /**
     * Paystack webhook with mandatory signature verification.
     * Docs: https://paystack.com/docs/payments/webhooks/
     */
    public function paystack(Request $request)
    {
        $payload = $request->all();
        $signature = $request->header('X-Paystack-Signature');
        $webhookSecret = config('services.paystack.webhook_secret', '');

        // Fail-closed: when a secret is configured, a valid signature is REQUIRED.
        if ($webhookSecret) {
            if (! $signature) {
                Log::warning('Paystack webhook rejected: missing signature');
                return response()->json(['error' => 'Missing signature'], 400);
            }

            $computed = hash_hmac('sha512', $request->getContent(), $webhookSecret);
            if (! hash_equals($computed, $signature)) {
                Log::warning('Paystack webhook signature mismatch');
                return response()->json(['error' => 'Invalid signature'], 400);
            }
        }

        $reference = $payload['data']['reference'] ?? null;

        if (! $reference) {
            return response()->json(['error' => 'No reference'], 400);
        }

        $event = $payload['event'] ?? '';
        Log::info('Paystack webhook received', ['reference' => $reference, 'event' => $event]);

        if ($event === 'charge.success') {
            $this->handleSuccessfulPayment($reference, PaymentProvider::PAYSTACK, $payload);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Monnify webhook with mandatory signature verification.
     * Docs: https://developers.monnify.com/webhooks
     */
    public function monnify(Request $request)
    {
        $payload = $request->all();
        $hash = $request->header('monnify-signature');
        $secretKey = config('services.monnify.secret_key', '');

        // Fail-closed: when a secret is configured, a valid signature is REQUIRED.
        if ($secretKey) {
            if (! $hash) {
                Log::warning('Monnify webhook rejected: missing signature');
                return response()->json(['error' => 'Missing signature'], 400);
            }

            $computed = hash_hmac('sha512', $request->getContent(), $secretKey);
            if (! hash_equals($computed, $hash)) {
                Log::warning('Monnify webhook signature mismatch');
                return response()->json(['error' => 'Invalid signature'], 400);
            }
        }

        $reference = $payload['paymentReference'] ?? $payload['data']['paymentReference'] ?? null;

        if (! $reference) {
            return response()->json(['error' => 'No reference'], 400);
        }

        Log::info('Monnify webhook received', ['reference' => $reference, 'eventType' => $payload['eventType'] ?? '']);

        if (($payload['eventType'] ?? '') === 'SUCCESSFUL') {
            $this->handleSuccessfulPayment($reference, PaymentProvider::MONNIFY, $payload);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Nomba webhook. Nomba does not publish a public signature scheme,
     * so we authenticate via a shared-secret header (X-Nomba-Signature).
     * Fail-closed when NOMBA_WEBHOOK_SECRET is configured.
     */
    public function nomba(Request $request)
    {
        $payload = $request->all();
        $webhookSecret = config('services.nomba.webhook_secret', '');

        if ($webhookSecret) {
            $signature = $request->header('X-Nomba-Signature');

            if (! $signature) {
                Log::warning('Nomba webhook rejected: missing signature');
                return response()->json(['error' => 'Missing signature'], 400);
            }

            $computed = hash_hmac('sha256', $request->getContent(), $webhookSecret);
            if (! hash_equals($computed, $signature)) {
                Log::warning('Nomba webhook signature mismatch');
                return response()->json(['error' => 'Invalid signature'], 400);
            }
        }

        $reference = $payload['reference'] ?? $payload['data']['reference'] ?? null;

        if (! $reference) {
            return response()->json(['error' => 'No reference'], 400);
        }

        Log::info('Nomba webhook received', ['reference' => $reference, 'status' => $payload['status'] ?? '']);

        if (($payload['status'] ?? '') === 'SUCCESS') {
            $this->handleSuccessfulPayment($reference, PaymentProvider::NOMBA, $payload);
        }

        return response()->json(['status' => 'ok']);
    }

    protected function handleSuccessfulPayment(string $reference, PaymentProvider $provider, array $payload): void
    {
        $transaction = Transaction::where('reference', $reference)->first();

        if (!$transaction) {
            Log::warning('Transaction not found for webhook', ['reference' => $reference, 'provider' => $provider->value]);
            return;
        }

        if ($transaction->status->isSuccessful()) {
            Log::info('Transaction already processed', ['reference' => $reference]);
            return;
        }

        // Use the PaymentService to activate subscription (single source of truth)
        if ($transaction->type->value === 'subscription' && $transaction->user_id) {
            $this->paymentService->activateSubscriptionForUser(
                $transaction->user_id,
                $reference,
                $payload
            );
        } else {
            // Non-subscription transaction — just mark as success
            $transaction->update([
                'status' => TransactionStatus::SUCCESS,
                'provider_response' => $payload,
                'paid_at' => now(),
            ]);
        }
    }
}
