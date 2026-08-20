<?php

namespace App\Services\Payment\Gateways;

use App\Enums\Payment\PaymentProvider;
use App\Services\Payment\PaymentGatewayInterface;
use App\ValueObjects\Money;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NombaGateway implements PaymentGatewayInterface
{
    private string $apiKey;
    private string $secretKey;
    private string $merchantId;
    private string $baseUrl = 'https://api.nomba.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.nomba.api_key', '');
        $this->secretKey = config('services.nomba.secret_key', '');
        $this->merchantId = config('services.nomba.merchant_id', '');
    }

    public function getProvider(): PaymentProvider
    {
        return PaymentProvider::NOMBA;
    }

    private function getAuthToken(): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'SecretKey' => $this->secretKey,
            'Content-Type' => 'application/json',
        ])->timeout(15)->post($this->baseUrl . '/auth/token');

        $data = $response->json();

        if (!isset($data['data']['token'])) {
            throw new \RuntimeException('Nomba auth failed: ' . ($data['message'] ?? 'Unknown'));
        }

        return $data['data']['token'];
    }

    private function authRequest(string $method, string $endpoint, array $data = []): array
    {
        $token = $this->getAuthToken();

        $http = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->timeout(30);

        $response = match(strtoupper($method)) {
            'GET' => $http->get($this->baseUrl . $endpoint),
            'POST' => $http->post($this->baseUrl . $endpoint, $data),
            default => throw new \RuntimeException("Unsupported HTTP method: {$method}"),
        };

        return $response->json();
    }

    public function initializePayment(
        string $email,
        Money $amount,
        string $reference,
        string $description,
        array $metadata = []
    ): array {
        $response = $this->authRequest('POST', '/orders/create', [
            'amount' => $amount->toInt(),
            'customerId' => $email,
            'callbackUrl' => config('app.url') . '/payment/callback/nomba',
            'reference' => $reference,
            'description' => $description,
        ]);

        if (!isset($response['data']['order']['orderNo'])) {
            throw new \RuntimeException('Nomba init failed: ' . ($response['message'] ?? 'Unknown'));
        }

        $orderNo = $response['data']['order']['orderNo'];

        return [
            'authorization_url' => $this->getCheckoutUrl($orderNo),
            'order_no' => $orderNo,
            'reference' => $reference,
        ];
    }

    public function verifyPayment(string $reference): array
    {
        $response = $this->authRequest('GET', "/orders/{$reference}");

        if (!isset($response['data']['order'])) {
            throw new \RuntimeException('Nomba verify failed: ' . ($response['message'] ?? 'Unknown'));
        }

        $order = $response['data']['order'];

        $statusMap = [
            'SUCCESS' => 'success',
            'FAILED' => 'failed',
            'PENDING' => 'pending',
        ];

        return [
            'status' => $statusMap[$order['status']] ?? 'failed',
            'amount' => $order['amount'],
            'currency' => 'NGN',
            'reference' => $order['reference'] ?? $order['orderNo'],
            'paid_at' => $order['paidDate'] ?? null,
            'channel' => $order['paymentMethod'] ?? null,
            'order_no' => $order['orderNo'],
        ];
    }

    public function initializeSubscription(
        string $email,
        Money $amount,
        string $reference,
        string $planCode,
        array $metadata = []
    ): array {
        $response = $this->authRequest('POST', '/orders/create', [
            'amount' => $amount->toInt(),
            'customerId' => $email,
            'callbackUrl' => config('app.url') . '/payment/callback/nomba',
            'reference' => $reference,
            'description' => "Subscription: {$planCode}",
        ]);

        if (!isset($response['data']['order']['orderNo'])) {
            throw new \RuntimeException('Nomba subscription init failed: ' . ($response['message'] ?? 'Unknown'));
        }

        $orderNo = $response['data']['order']['orderNo'];

        return [
            'authorization_url' => $this->getCheckoutUrl($orderNo),
            'order_no' => $orderNo,
        ];
    }

    public function createSubaccount(
        string $businessName,
        string $bankCode,
        string $accountNumber,
        float $percentageCharge
    ): array {
        $response = $this->authRequest('POST', '/merchant/subaccounts', [
            'businessName' => $businessName,
            'bankCode' => $bankCode,
            'accountNumber' => $accountNumber,
            'percentageCharge' => $percentageCharge,
        ]);

        if (!isset($response['data'])) {
            throw new \RuntimeException('Nomba subaccount failed: ' . ($response['message'] ?? 'Unknown'));
        }

        return $response['data'];
    }

    public function createTransferRecipient(
        string $name,
        string $bankCode,
        string $accountNumber
    ): array {
        $response = $this->authRequest('POST', '/transfer/recipients', [
            'name' => $name,
            'bankCode' => $bankCode,
            'accountNumber' => $accountNumber,
            'type' => 'bank_account',
        ]);

        if (!isset($response['data'])) {
            throw new \RuntimeException('Nomba recipient failed: ' . ($response['message'] ?? 'Unknown'));
        }

        return $response['data'];
    }

    public function initiateTransfer(
        string $recipientCode,
        Money $amount,
        string $reference
    ): array {
        $response = $this->authRequest('POST', '/transfer/single', [
            'recipientCode' => $recipientCode,
            'amount' => $amount->toInt(),
            'reference' => $reference,
            'narration' => 'BLOSSOM Magazine payout',
        ]);

        if (!isset($response['data'])) {
            throw new \RuntimeException('Nomba transfer failed: ' . ($response['message'] ?? 'Unknown'));
        }

        return $response['data'];
    }

    private function getCheckoutUrl(string $orderNo): string
    {
        return "https://checkout.nomba.com/orders/{$orderNo}/pay";
    }
}
