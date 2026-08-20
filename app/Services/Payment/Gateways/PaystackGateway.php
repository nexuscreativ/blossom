<?php

namespace App\Services\Payment\Gateways;

use App\Enums\Payment\PaymentProvider;
use App\Services\Payment\PaymentGatewayInterface;
use App\ValueObjects\Money;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackGateway implements PaymentGatewayInterface
{
    private string $secretKey;
    private string $publicKey;
    private string $baseUrl = 'https://api.paystack.co';

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key', '');
        $this->publicKey = config('services.paystack.public_key', '');
    }

    public function getProvider(): PaymentProvider
    {
        return PaymentProvider::PAYSTACK;
    }

    public function initializePayment(
        string $email,
        Money $amount,
        string $reference,
        string $description,
        array $metadata = []
    ): array {
        $response = $this->post('/transaction/initialize', [
            'email' => $email,
            'amount' => $amount->toInt(),
            'reference' => $reference,
            'callback_url' => config('app.url') . '/payment/callback/paystack',
            'metadata' => array_merge([
                'description' => $description,
            ], $metadata),
        ]);

        if (!$response['status']) {
            throw new \RuntimeException('Paystack init failed: ' . ($response['message'] ?? 'Unknown error'));
        }

        return [
            'authorization_url' => $response['data']['authorization_url'],
            'access_code' => $response['data']['access_code'],
            'reference' => $response['data']['reference'],
        ];
    }

    public function verifyPayment(string $reference): array
    {
        $response = $this->get("/transaction/verify/{$reference}");

        if (!$response['status']) {
            throw new \RuntimeException('Paystack verify failed: ' . ($response['message'] ?? 'Unknown'));
        }

        $data = $response['data'];

        return [
            'status' => $data['status'] === 'success' ? 'success' : 'failed',
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'reference' => $data['reference'],
            'paid_at' => $data['paid_at'] ?? null,
            'channel' => $data['channel'] ?? null,
            'gateway_response' => $data['gateway_response'] ?? null,
            'metadata' => $data['metadata'] ?? [],
            'customer' => $data['customer'] ?? [],
        ];
    }

    public function initializeSubscription(
        string $email,
        Money $amount,
        string $reference,
        string $planCode,
        array $metadata = []
    ): array {
        $response = $this->post('/subscription', [
            'email' => $email,
            'plan' => $planCode,
            'amount' => $amount->toInt(),
            'callback_url' => config('app.url') . '/payment/callback/paystack',
            'start_date' => now()->addMinutes(5)->format('Y-m-d\TH:i:s+00:00'),
        ]);

        if (!$response['status']) {
            throw new \RuntimeException('Paystack subscription failed: ' . ($response['message'] ?? 'Unknown'));
        }

        return [
            'authorization_url' => $response['data']['authorization_url'],
            'access_code' => $response['data']['access_code'],
            'subscription_code' => $response['data']['subscription_code'] ?? null,
        ];
    }

    public function createSubaccount(
        string $businessName,
        string $bankCode,
        string $accountNumber,
        float $percentageCharge
    ): array {
        $response = $this->post('/subaccount', [
            'business_name' => $businessName,
            'settlement_bank' => $bankCode,
            'account_number' => $accountNumber,
            'percentage_charge' => $percentageCharge,
        ]);

        if (!$response['status']) {
            throw new \RuntimeException('Paystack subaccount failed: ' . ($response['message'] ?? 'Unknown'));
        }

        return $response['data'];
    }

    public function createTransferRecipient(
        string $name,
        string $bankCode,
        string $accountNumber
    ): array {
        $response = $this->post('/transferrecipient', [
            'type' => 'nuban',
            'name' => $name,
            'bank_code' => $bankCode,
            'account_number' => $accountNumber,
            'currency' => 'NGN',
        ]);

        if (!$response['status']) {
            throw new \RuntimeException('Paystack recipient failed: ' . ($response['message'] ?? 'Unknown'));
        }

        return $response['data'];
    }

    public function initiateTransfer(
        string $recipientCode,
        Money $amount,
        string $reference
    ): array {
        $response = $this->post('/transfer', [
            'source' => 'balance',
            'amount' => $amount->toInt(),
            'recipient' => $recipientCode,
            'reference' => $reference,
            'reason' => 'BLOSSOM Magazine payout',
        ]);

        if (!$response['status']) {
            throw new \RuntimeException('Paystack transfer failed: ' . ($response['message'] ?? 'Unknown'));
        }

        return $response['data'];
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    private function post(string $endpoint, array $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->timeout(30)->post($this->baseUrl . $endpoint, $data);

        return $response->json();
    }

    private function get(string $endpoint): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->timeout(30)->get($this->baseUrl . $endpoint);

        return $response->json();
    }
}
