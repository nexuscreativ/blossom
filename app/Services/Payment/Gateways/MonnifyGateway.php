<?php

namespace App\Services\Payment\Gateways;

use App\Enums\Payment\PaymentProvider;
use App\Services\Payment\PaymentGatewayInterface;
use App\ValueObjects\Money;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonnifyGateway implements PaymentGatewayInterface
{
    private string $apiKey;
    private string $secretKey;
    private string $contractCode;
    private string $baseUrl = 'https://api.monnify.com';

    public function __construct()
    {
        $this->apiKey = config('services.monnify.api_key', '');
        $this->secretKey = config('services.monnify.secret_key', '');
        $this->contractCode = config('services.monnify.contract_code', '');
    }

    public function getProvider(): PaymentProvider
    {
        return PaymentProvider::MONNIFY;
    }

    private function getAccessToken(): string
    {
        $response = Http::withBasicAuth($this->apiKey, $this->secretKey)
            ->timeout(15)
            ->post($this->baseUrl . '/api/v1/auth/login');

        $data = $response->json();

        if (!isset($data['responseBody']['accessToken'])) {
            throw new \RuntimeException('Monnify auth failed');
        }

        return $data['responseBody']['accessToken'];
    }

    private function authPost(string $endpoint, array $data): array
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->timeout(30)
            ->post($this->baseUrl . $endpoint, $data);

        return $response->json();
    }

    private function authGet(string $endpoint): array
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->timeout(30)
            ->get($this->baseUrl . $endpoint);

        return $response->json();
    }

    public function initializePayment(
        string $email,
        Money $amount,
        string $reference,
        string $description,
        array $metadata = []
    ): array {
        $response = $this->authPost('/api/v1/merchant/payments/init-transaction', [
            'amount' => $amount->toNaira(),
            'customerName' => $email,
            'customerEmail' => $email,
            'paymentReference' => $reference,
            'paymentDescription' => $description,
            'contractCode' => $this->contractCode,
            'redirectUrl' => config('app.url') . '/payment/callback/monnify',
            'currencyCode' => 'NGN',
        ]);

        if (!isset($response['responseBody']['transactionReference'])) {
            throw new \RuntimeException('Monnify init failed: ' . ($response['responseMessage'] ?? 'Unknown'));
        }

        return [
            'authorization_url' => $response['responseBody']['paymentUrl'],
            'transaction_reference' => $response['responseBody']['transactionReference'],
            'reference' => $reference,
        ];
    }

    public function verifyPayment(string $reference): array
    {
        $response = $this->authGet("/api/v1/merchant/transactions/query?paymentReference={$reference}");

        if (!isset($response['responseBody'])) {
            throw new \RuntimeException('Monnify verify failed: ' . ($response['responseMessage'] ?? 'Unknown'));
        }

        $data = $response['responseBody'];

        return [
            'status' => $data['transactionStatus'] === 'PAID' ? 'success' : 'failed',
            'amount' => $data['amountPaid'] * 100, // convert to kobo
            'currency' => 'NGN',
            'reference' => $data['paymentReference'],
            'paid_at' => $data['paidOn'] ?? null,
            'channel' => $data['paymentMethod'] ?? null,
            'transaction_reference' => $data['transactionReference'] ?? null,
            'customer' => [
                'email' => $data['customerEmail'] ?? null,
                'name' => $data['customerName'] ?? null,
            ],
        ];
    }

    public function initializeSubscription(
        string $email,
        Money $amount,
        string $reference,
        string $planCode,
        array $metadata = []
    ): array {
        $response = $this->authPost('/api/v1/merchant/payments/init-transaction', [
            'amount' => $amount->toNaira(),
            'customerName' => $email,
            'customerEmail' => $email,
            'paymentReference' => $reference,
            'paymentDescription' => "Subscription: {$planCode}",
            'contractCode' => $this->contractCode,
            'redirectUrl' => config('app.url') . '/payment/callback/monnify',
            'currencyCode' => 'NGN',
            'incomeSplitConfig' => [
                [
                    'splitType' => 'FLAT',
                    'splitValue' => 0,
                    'splitPercentage' => 0,
                ],
            ],
        ]);

        if (!isset($response['responseBody']['transactionReference'])) {
            throw new \RuntimeException('Monnify subscription init failed: ' . ($response['responseMessage'] ?? 'Unknown'));
        }

        return [
            'authorization_url' => $response['responseBody']['paymentUrl'],
            'transaction_reference' => $response['responseBody']['transactionReference'],
        ];
    }

    public function createSubaccount(
        string $businessName,
        string $bankCode,
        string $accountNumber,
        float $percentageCharge
    ): array {
        $response = $this->authPost('/api/v2/SubAccount', [
            'businessName' => $businessName,
            'bankCode' => $bankCode,
            'accountNumber' => $accountNumber,
            'percentageCharge' => $percentageCharge,
            'businessContact' => '',
            'businessContactEmail' => '',
            'currencyCode' => 'NGN',
        ]);

        if (!isset($response['responseBody']['subAccountCode'])) {
            throw new \RuntimeException('Monnify subaccount failed: ' . ($response['responseMessage'] ?? 'Unknown'));
        }

        return $response['responseBody'];
    }

    public function createTransferRecipient(
        string $name,
        string $bankCode,
        string $accountNumber
    ): array {
        $response = $this->authPost('/api/v2/Beneficiary', [
            'name' => $name,
            'bankCode' => $bankCode,
            'accountNumber' => $accountNumber,
        ]);

        if (!isset($response['responseBody']['beneficiaryCode'])) {
            throw new \RuntimeException('Monnify recipient failed: ' . ($response['responseMessage'] ?? 'Unknown'));
        }

        return $response['responseBody'];
    }

    public function initiateTransfer(
        string $recipientCode,
        Money $amount,
        string $reference
    ): array {
        $response = $this->authPost('/api/v2/disbursements/single', [
            'amount' => $amount->toNaira(),
            'beneficiaryCode' => $recipientCode,
            'reference' => $reference,
            'narration' => 'BLOSSOM Magazine payout',
        ]);

        if (!isset($response['responseBody']['transactionReference'])) {
            throw new \RuntimeException('Monnify transfer failed: ' . ($response['responseMessage'] ?? 'Unknown'));
        }

        return $response['responseBody'];
    }
}
