<?php

namespace App\Http\Controllers;

use App\Enums\Payment\PaymentProvider;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function handle(Request $request, string $provider)
    {
        $reference = match($provider) {
            'paystack' => $request->query('reference') ?? $request->query('trxref'),
            'monnify' => $request->query('paymentReference'),
            'nomba' => $request->query('reference'),
            default => null,
        };

        if (!$reference) {
            return redirect()->route('pricing')
                ->with('error', 'Payment reference not found. Please try again.');
        }

        try {
            $providerEnum = PaymentProvider::from($provider);
            $result = $this->paymentService->verifyPayment($reference, $providerEnum);

            if ($result['status'] === 'success') {
                // Get user_id from the transaction metadata
                $transaction = \App\Models\Transaction::where('reference', $reference)->first();
                $userId = $transaction->user_id ?? $result['customer']['metadata']['user_id'] ?? null;

                if ($userId) {
                    $this->paymentService->activateSubscriptionForUser($userId, $reference, $result);
                }

                return redirect()->route('dashboard')
                    ->with('success', 'Payment successful! Your subscription is now active.');
            }

            return redirect()->route('pricing')
                ->with('error', 'Payment was not successful. Please try again.');
        } catch (\Exception $e) {
            Log::error('Payment callback error', [
                'provider' => $provider,
                'reference' => $reference,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('pricing')
                ->with('error', 'An error occurred verifying your payment. Please contact support.');
        }
    }
}
