# BLOSSOM — Triple Payment Provider Architecture

## Paystack Integration + Revised Triple-Provider Strategy

**Version:** 1.0  
**Date:** August 18, 2026  
**Status:** Production-Ready Architecture  
**Providers:** Paystack (primary subscriptions) | Nomba (general collections) | Monnify (recurring splits)

---

## Table of Contents

1. [Payment Provider Comparison](#1-payment-provider-comparison-table)
2. [Triple-Provider Strategy](#2-revised-triple-payment-strategy)
3. [Paystack API Integration](#3-paystack-api-integration)
4. [Unified PaymentGatewayInterface](#4-unified-paymentgatewayinterface)
5. [PaymentService Orchestrator](#5-paymentservice-orchestrator)
6. [Complete Laravel Implementation](#6-complete-laravel-implementation)
7. [Database Schema](#7-revised-database-schema)
8. [Routes](#8-updated-routes)
9. [Configuration](#9-configuration-files)
10. [Revised Phase Plan](#10-revised-phase-plan)

---

## 1. Payment Provider Comparison Table

### Side-by-Side Feature Comparison

| Feature | Paystack | Nomba (OPay) | Monnify (Moniepoint) |
|---------|----------|--------------|----------------------|
| **Parent Company** | Stripe (acquired 2020) | Opera Group | Moniepoint Microfinance Bank |
| **Founded** | 2015 (Lagos) | 2018 (Lagos) | 2019 (Lagos) |
| **NIBSS License** | Yes | Yes | Yes |
| **CBN PSP License** | Yes | Yes | Yes |

### Transaction Fees

| Fee Type | Paystack | Nomba | Monnify |
|----------|----------|-------|---------|
| **Local Card (NGN)** | 1.5% + ₦100 (capped ₦2,000) | 1.0% (capped ₦1,000) | 1.0% (capped ₦1,000) |
| **International Card** | 3.9% + ₦100 | 3.5% + ₦100 | 3.5% + ₦100 |
| **Bank Transfer** | 1.5% + ₦100 | 1.0% | 1.0% |
| **USSD** | ₦50 flat | ₦50 flat | ₦50 flat |
| **Wallet** | 1.5% + ₦100 | 0.5% | 0.5% |
| **Settlement Fee** | Free | Free | Free |
| **Chargeback Fee** | ₦2,500 | ₦2,000 | ₦2,000 |
| **Payout Fee** | Free (daily) | Free (daily) | Free (daily) |

### Subscription & Recurring Billing

| Capability | Paystack | Nomba | Monnify |
|------------|----------|-------|---------|
| **Plan-Based Billing** | ✅ Native plans API | ⚠️ Manual intervals | ✅ Native plans API |
| **Auto-Charge on Renewal** | ✅ Automatic | ❌ Requires re-init | ✅ Automatic |
| **Subscription Management** | ✅ Full CRUD via API | ⚠️ Limited | ✅ Full CRUD via API |
| **Metered Billing** | ❌ Not supported | ❌ Not supported | ❌ Not supported |
| **Trial Periods** | ✅ Free trials | ⚠️ Workaround | ✅ Free trials |
| **Pause/Resume** | ✅ Supported | ❌ Not supported | ✅ Supported |
| **Subscription Invoicing** | ✅ Auto-invoices | ❌ Manual | ✅ Auto-invoices |
| **Retry Failed Payments** | ✅ Smart retries | ❌ No retry | ✅ Retry supported |
| **Dunning Management** | ✅ Built-in | ❌ Not available | ⚠️ Basic |

### Split Payments

| Capability | Paystack | Nomba | Monnify |
|------------|----------|-------|---------|
| **Sub-Account Splits** | ✅ Sub-accounts | ⚠️ Manual settlement | ✅ Sub-accounts |
| **Percentage Splits** | ✅ Flexible % | ❌ Not supported | ✅ Flexible % |
| **Fixed Amount Splits** | ✅ Supported | ❌ Not supported | ✅ Supported |
| **Multiple Beneficiaries** | ✅ Up to 15 | ❌ Not supported | ✅ Up to 5 |
| **Instant Split** | ✅ Real-time | ❌ Settlement only | ✅ Real-time |
| **Split for Marketplace** | ✅ Purpose-built | ❌ Not designed | ✅ Purpose-built |

### Payment Method Coverage

| Method | Paystack | Nomba | Monnify |
|--------|----------|-------|---------|
| **Debit Cards** | ✅ Visa, Mastercard, Verve | ✅ Visa, Mastercard, Verve | ✅ Visa, Mastercard, Verve |
| **Credit Cards** | ✅ Visa, Mastercard | ⚠️ Limited | ⚠️ Limited |
| **Bank Transfer** | ✅ All banks | ✅ All banks | ✅ All banks |
| **USSD** | ✅ 20+ banks | ✅ 15+ banks | ✅ 15+ banks |
| **Mobile Money** | ⚠️ Limited | ✅ OPay wallet | ⚠️ Limited |
| **QR Code** | ✅ NQR supported | ✅ NQR supported | ✅ NQR supported |
| **Pay with Bank** | ✅ Direct debit | ✅ Direct debit | ✅ Direct debit |
| **Apple Pay** | ✅ Supported | ❌ Not supported | ❌ Not supported |
| **Visa Checkout** | ✅ Supported | ❌ Not supported | ❌ Not supported |

### Dashboard & Analytics

| Feature | Paystack | Nomba | Monnify |
|---------|----------|-------|---------|
| **Transaction Dashboard** | ✅ Excellent | ✅ Good | ✅ Good |
| **Real-Time Analytics** | ✅ Sub-second | ✅ Real-time | ✅ Real-time |
| **Revenue Reports** | ✅ Detailed | ✅ Basic | ✅ Good |
| **Customer Insights** | ✅ Cohort analysis | ⚠️ Basic | ⚠️ Basic |
| **Export (CSV/PDF)** | ✅ Both | ✅ CSV only | ✅ Both |
| **API Documentation** | ✅ Excellent (OpenAPI) | ⚠️ Adequate | ⚠️ Adequate |
| **Sandbox/Testing** | ✅ Full sandbox | ✅ Test mode | ✅ Test mode |
| **Webhook Logs** | ✅ Full history | ⚠️ Limited | ✅ Good |
| **Mobile App** | ✅ iOS/Android | ✅ OPay app | ✅ Moniepoint app |

### Settlement Speed

| Settlement | Paystack | Nomba | Monnify |
|------------|----------|-------|---------|
| **Standard** | T+1 (next business day) | T+1 | T+1 |
| **Instant Payout** | ✅ Available (0.5% fee) | ✅ Available (1% fee) | ✅ Available (0.5% fee) |
| **Weekend/Holiday** | Next business day | Next business day | Next business day |
| **Minimum Payout** | ₦5,000 | ₦10,000 | ₦5,000 |
| **Payout Schedule** | Daily automatic | Daily automatic | Daily automatic |

### Reliability & Support

| Metric | Paystack | Nomba | Monnify |
|--------|----------|-------|---------|
| **Uptime SLA** | 99.9% | 99.5% | 99.5% |
| **API Response Time** | <200ms (p95) | <500ms (p95) | <500ms (p95) |
| **Customer Support** | ✅ Excellent (chat, email, phone) | ⚠️ Adequate (email, chat) | ⚠️ Adequate (email, phone) |
| **Technical Support** | ✅ Dedicated for businesses | ⚠️ General support | ⚠️ General support |
| **Status Page** | ✅ status.paystack.com | ❌ Not public | ❌ Not public |

### Best Use Case for BLOSSOM

| Provider | Best BLOSSOM Use Case | Why |
|----------|----------------------|-----|
| **Paystack** | Premium subscriptions, digital content billing, international readers | Best subscription engine, excellent dunning, Stripe backing, international card support |
| **Nomba** | One-time ad payments, event ticket sales, general collections | Lowest fees for local transactions, OPay ecosystem reach |
| **Monnify** | Listing fees with split to featured vendors, institutional billing | Best split-payment for marketplace model, institutional relationships |

---

## 2. Revised Triple Payment Strategy

### Provider Routing Matrix

```
┌─────────────────────────────────────────────────────────────────────┐
│                    BLOSSOM PAYMENT ROUTER                          │
│                                                                     │
│  Transaction Type → Provider Selection → Fallback                   │
│                                                                     │
│  ┌──────────────────┐  ┌──────────────┐  ┌────────────────────┐   │
│  │ SUBSCRIPTIONS    │→ │ PAYSTACK     │→ │ MONNIFY → NOMBA    │   │
│  │ (Premium, Inst.) │  │ (Primary)    │  │ (Fallback chain)   │   │
│  └──────────────────┘  └──────────────┘  └────────────────────┘   │
│                                                                     │
│  ┌──────────────────┐  ┌──────────────┐  ┌────────────────────┐   │
│  │ LISTINGS/SPLITS  │→ │ MONNIFY      │→ │ PAYSTACK → NOMBA   │   │
│  │ (Vendor payouts) │  │ (Primary)    │  │ (Fallback chain)   │   │
│  └──────────────────┘  └──────────────┘  └────────────────────┘   │
│                                                                     │
│  ┌──────────────────┐  ┌──────────────┐  ┌────────────────────┐   │
│  │ ONE-TIME PAYMENTS│→ │ NOMBA        │→ │ PAYSTACK → MONNIFY │   │
│  │ (Ads, events)    │  │ (Primary)    │  │ (Fallback chain)   │   │
│  └──────────────────┘  └──────────────┘  └────────────────────┘   │
│                                                                     │
│  ┌──────────────────┐  ┌──────────────┐  ┌────────────────────┐   │
│  │ INTERNATIONAL    │→ │ PAYSTACK     │→ │ MONNIFY            │   │
│  │ (Diaspora cards) │  │ (Primary)    │  │ (Fallback)         │   │
│  └──────────────────┘  └──────────────┘  └────────────────────┘   │
│                                                                     │
│  ┌──────────────────┐  ┌──────────────┐  ┌────────────────────┐   │
│  │ WEBHOOK ENTRY    │→ │ ROUTER       │→ │ Signature verify   │   │
│  │ (Any provider)   │  │ (Dispatch)   │  │ → process          │   │
│  └──────────────────┘  └──────────────┘  └────────────────────┘   │
└─────────────────────────────────────────────────────────────────────┘
```

### Routing Decision Logic

```php
// Pseudocode for provider selection
function selectProvider(TransactionType $type, PaymentContext $context): string
{
    // Rule 1: International cards always go to Paystack
    if ($context->isInternationalCard()) {
        return 'paystack';
    }

    // Rule 2: Subscriptions prefer Paystack (best recurring billing)
    if ($type->isSubscription()) {
        return $this->getWithFallback('paystack', 'monnify', 'nomba');
    }

    // Rule 3: Split payments prefer Monnify (best marketplace splits)
    if ($type->requiresSplit()) {
        return $this->getWithFallback('monnify', 'paystack', 'nomba');
    }

    // Rule 4: One-time payments prefer Nomba (lowest fees)
    if ($type->isOneTime()) {
        return $this->getWithFallback('nomba', 'paystack', 'monnify');
    }

    // Default: Paystack (most reliable)
    return 'paystack';
}
```

### Cost Optimization Analysis

For a ₦20,000 annual Premium subscription:

| Provider | Fee | Net to BLOSSOM | Savings vs Worst |
|----------|-----|----------------|------------------|
| **Paystack** | ₦300 + ₦100 = ₦400 | ₦19,600 | ₦0 (baseline) |
| **Nomba** | ₦200 + ₦100 = ₦300 | ₦19,700 | ₦100 more |
| **Monnify** | ₦200 + ₦100 = ₦300 | ₦19,700 | ₦100 more |

**Strategy:** Use Paystack for subscriptions (reliability > ₦100 savings). Use Nomba for ad payments (volume → savings compound).

---

## 3. Paystack API Integration

### 3.1 Paystack API Overview

**Base URL:** `https://api.paystack.co`  
**Auth:** Bearer token (secret key)  
**Versioning:** URL-based (`/transaction/initialize`, not `/v1/...`)  
**Rate Limit:** 500 requests/minute (per secret key)

### 3.2 Key Endpoints

| Endpoint | Method | Purpose | BLOSSOM Usage |
|----------|--------|---------|---------------|
| `/transaction/initialize` | POST | Start a payment, get authorization URL | Checkout flow |
| `/transaction/verify` | GET | Verify transaction by reference | Webhook + return URL |
| `/transaction/{id}` | GET | Get single transaction details | Admin dashboard |
| `/transaction` | GET | List transactions (paginated) | Financial reports |
| `/transaction/charge_authorization` | POST | Charge saved card (recurring) | Subscription renewals |
| `/transaction/totals` | GET | Aggregate transaction data | Dashboard KPIs |
| `/plan` | POST | Create a billing plan | Subscription tier setup |
| `/plan` | GET | List all plans | Admin management |
| `/plan/{id}` | GET | Get plan details | Plan display |
| `/subscription` | POST | Create customer subscription | New subscriber |
| `/subscription` | GET | List subscriptions | Admin dashboard |
| `/subscription/{id}` | GET | Get subscription details | Subscriber management |
| `/subscription/disable` | POST | Cancel subscription | Cancellation flow |
| `/subscription/enable` | POST | Reactivate subscription | Re-activation flow |
| `/customer` | POST/GET | Create/list customers | User management |
| `/split` | POST | Create split group | Listing vendor splits |
| `/split/{id}` | PUT | Update split group | Adjust vendor shares |
| `/subaccount` | POST | Create sub-account | Vendor onboarding |
| `/subaccount` | GET | List sub-accounts | Admin vendor list |

### 3.3 Paystack Plan-Based Billing Flow

```
1. CREATE PLAN (once per tier)
   POST /plan
   { name: "BLOSSOM Premium Monthly", amount: 250000, interval: "monthly" }
   { name: "BLOSSOM Premium Annual",  amount: 2000000, interval: "annually" }
   { name: "BLOSSOM Institution",     amount: 10000000, interval: "annually" }
   → Returns plan_code

2. INITIALIZE TRANSACTION (each checkout)
   POST /transaction/initialize
   { email, amount, plan: plan_code, metadata: { user_id, plan_tier } }
   → Returns authorization_url, access_code, reference

3. CUSTOMER COMPLETES PAYMENT
   → Redirected to /subscribe/callback?trxref=xxx

4. VERIFY TRANSACTION
   GET /transaction/verify/{reference}
   → Confirms payment, triggers subscription activation

5. SUBSCRIPTION AUTO-RENEWS
   → Paystack auto-charges saved authorization
   → Sends webhook: charge.success, invoice.created, invoice.payment_failed

6. WEBHOOK HANDLING
   POST /webhooks/paystack
   → Verify HMAC signature → Process event → Update local state
```

### 3.4 Webhook Events to Handle

| Event | Action |
|-------|--------|
| `charge.success` | Mark transaction complete, activate subscription |
| `charge.failed` | Mark failed, notify user, trigger retry |
| `invoice.created` | Log upcoming renewal |
| `invoice.payment_failed` | Start dunning sequence |
| `invoice.updated` | Update invoice records |
| `subscription.create` | Sync subscription state |
| `subscription.disable` | Process cancellation |
| `subscription.not_renewing` | Mark as cancelling at period end |
| `subscription.expired` | Expire access, prompt renewal |

---

## 4. Unified PaymentGatewayInterface

```php
<?php
// app/Contracts/PaymentGatewayInterface.php

declare(strict_types=1);

namespace App\Contracts;

use App\DTOs\Payment\{
    PaymentInitializationRequest,
    PaymentInitializationResponse,
    PaymentVerificationResponse,
    SubscriptionCreationRequest,
    SubscriptionCreationResponse,
    SubscriptionStatusResponse,
    PlanCreationRequest,
    PlanCreationResponse,
    SplitCreationRequest,
    SplitCreationResponse,
    CustomerCreationRequest,
    CustomerCreationResponse,
    WebhookPayload
};
use App\Enums\Payment\{
    PaymentProvider,
    TransactionStatus,
    SubscriptionStatus
};

/**
 * Unified payment gateway contract.
 *
 * All providers (Paystack, Nomba, Monnify) implement this interface,
 * enabling the PaymentService orchestrator to switch providers transparently.
 */
interface PaymentGatewayInterface
{
    /**
     * Get the provider identifier.
     */
    public function getProvider(): PaymentProvider;

    // ─── Transaction Lifecycle ──────────────────────────────────────

    /**
     * Initialize a new payment transaction.
     *
     * @throws PaymentGatewayException
     */
    public function initializePayment(
        PaymentInitializationRequest $request
    ): PaymentInitializationResponse;

    /**
     * Verify a completed transaction by reference.
     *
     * @throws PaymentGatewayException
     * @throws TransactionNotFoundException
     */
    public function verifyTransaction(
        string $reference
    ): PaymentVerificationResponse;

    /**
     * Fetch a transaction by provider ID.
     *
     * @throws TransactionNotFoundException
     */
    public function fetchTransaction(
        string $providerTransactionId
    ): PaymentVerificationResponse;

    // ─── Plans ─────────────────────────────────────────────────────

    /**
     * Create a billing plan on the provider.
     */
    public function createPlan(
        PlanCreationRequest $request
    ): PlanCreationResponse;

    /**
     * Fetch a plan by provider plan code/ID.
     */
    public function fetchPlan(string $planCode): PlanCreationResponse;

    // ─── Subscriptions ─────────────────────────────────────────────

    /**
     * Create a new subscription for a customer.
     */
    public function createSubscription(
        SubscriptionCreationRequest $request
    ): SubscriptionCreationResponse;

    /**
     * Get current subscription status.
     */
    public function fetchSubscriptionStatus(
        string $subscriptionCode
    ): SubscriptionStatusResponse;

    /**
     * Cancel a subscription.
     */
    public function cancelSubscription(
        string $subscriptionCode
    ): bool;

    /**
     * Enable/reactivate a paused subscription.
     */
    public function enableSubscription(
        string $subscriptionCode
    ): bool;

    // ─── Customers ─────────────────────────────────────────────────

    /**
     * Create or retrieve a customer record on the provider.
     */
    public function createCustomer(
        CustomerCreationRequest $request
    ): CustomerCreationResponse;

    // ─── Split Payments ────────────────────────────────────────────

    /**
     * Create a split (sub-account group) for marketplace payouts.
     */
    public function createSplit(
        SplitCreationRequest $request
    ): SplitCreationResponse;

    // ─── Webhook Processing ────────────────────────────────────────

    /**
     * Verify webhook signature authenticity.
     */
    public function verifyWebhookSignature(
        string $payload,
        string $signature
    ): bool;

    /**
     * Parse and process an incoming webhook event.
     *
     * @return array{event: string, data: array, processed: bool}
     */
    public function processWebhook(
        WebhookPayload $payload
    ): array;
}
```

---

## 5. PaymentService Orchestrator

```php
<?php
// app/Services/Payment/PaymentService.php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\DTOs\Payment\{
    PaymentInitializationRequest,
    PaymentInitializationResponse,
    PaymentVerificationResponse,
    SubscriptionCreationRequest,
    SubscriptionCreationResponse,
    SubscriptionStatusResponse
};
use App\Enums\Payment\{PaymentProvider, TransactionType};
use App\Exceptions\Payment\{
    PaymentGatewayException,
    AllGatewaysFailedException
};
use App\Models\{PaymentTransaction, Subscription, User};
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Payment orchestrator with smart routing and fallback.
 *
 * Routes transactions to the optimal provider based on type,
 * with automatic fallback if the primary provider fails.
 */
class PaymentService
{
    /**
     * Provider priority chains keyed by transaction type.
     *
     * @var array<string, array<PaymentProvider>>
     */
    private const ROUTING_TABLE = [
        TransactionType::SUBSCRIPTION->value    => [PaymentProvider::PAYSTACK, PaymentProvider::MONNIFY, PaymentProvider::NOMBA],
        TransactionType::RECURRING_SPLIT->value  => [PaymentProvider::MONNIFY, PaymentProvider::PAYSTACK, PaymentProvider::NOMBA],
        TransactionType::ONE_TIME->value          => [PaymentProvider::NOMBA, PaymentProvider::PAYSTACK, PaymentProvider::MONNIFY],
        TransactionType::INTERNATIONAL->value     => [PaymentProvider::PAYSTACK, PaymentProvider::MONNIFY, PaymentProvider::NOMBA],
    ];

    /** @var array<string, PaymentGatewayInterface> */
    private array $gateways = [];

    public function __construct(
        PaystackGateway $paystack,
        NombaGateway $nomba,
        MonnifyGateway $monnify,
    ) {
        $this->gateways = [
            PaymentProvider::PAYSTACK->value => $paystack,
            PaymentProvider::NOMBA->value    => $nomba,
            PaymentProvider::MONNIFY->value  => $monnify,
        ];
    }

    /**
     * Get the gateway instance for a provider.
     */
    public function gateway(PaymentProvider $provider): PaymentGatewayInterface
    {
        $gateway = $this->gateways[$provider->value] ?? null;

        if ($gateway === null) {
            throw new \InvalidArgumentException(
                "No gateway registered for provider: {$provider->value}"
            );
        }

        return $gateway;
    }

    // ─── Smart Routing: Initialize Payment ─────────────────────────

    /**
     * Initialize a payment with automatic provider selection and fallback.
     */
    public function initializePayment(
        PaymentInitializationRequest $request,
        ?TransactionType $type = null
    ): PaymentInitializationResponse {
        $transactionType = $type ?? $this->inferTransactionType($request);
        $chain = $this->resolveProviderChain($transactionType, $request);
        $lastException = null;

        foreach ($chain as $provider) {
            $gateway = $this->gateway($provider);

            try {
                Log::info('Attempting payment initialization', [
                    'provider' => $provider->value,
                    'type' => $transactionType->value,
                    'email' => $request->email,
                    'amount' => $request->amount,
                ]);

                $response = $gateway->initializePayment($request);

                // Record the successful provider choice for analytics
                $this->recordRoutingDecision($transactionType, $provider, success: true);

                return $response;
            } catch (PaymentGatewayException $e) {
                $lastException = $e;

                Log::warning('Payment provider failed, trying next', [
                    'provider' => $provider->value,
                    'error' => $e->getMessage(),
                    'type' => $transactionType->value,
                ]);

                $this->recordRoutingDecision($transactionType, $provider, success: false);
            }
        }

        throw new AllGatewaysFailedException(
            "All payment providers failed for transaction type: {$transactionType->value}",
            previous: $lastException
        );
    }

    // ─── Smart Routing: Verify Transaction ─────────────────────────

    /**
     * Verify a transaction — uses stored provider reference.
     */
    public function verifyTransaction(string $reference): PaymentVerificationResponse
    {
        // Look up which provider handled this transaction
        $transaction = PaymentTransaction::where('reference', $reference)->first();

        if ($transaction === null) {
            // Try all providers (for webhook-initiated verification)
            return $this->verifyAcrossProviders($reference);
        }

        $gateway = $this->gateway($transaction->provider);

        return $gateway->verifyTransaction($reference);
    }

    /**
     * Try verifying across all providers (fallback for orphaned references).
     */
    private function verifyAcrossProviders(string $reference): PaymentVerificationResponse
    {
        foreach ($this->gateways as $provider => $gateway) {
            try {
                $result = $gateway->verifyTransaction($reference);
                if ($result->status->isSuccessful()) {
                    return $result;
                }
            } catch (\Throwable) {
                continue;
            }
        }

        throw new PaymentGatewayException(
            "Transaction {$reference} could not be verified on any provider"
        );
    }

    // ─── Subscription Management ───────────────────────────────────

    /**
     * Create a subscription using the optimal provider.
     */
    public function createSubscription(
        SubscriptionCreationRequest $request,
        ?PaymentProvider $preferred = null
    ): SubscriptionCreationResponse {
        $chain = $preferred
            ? [$preferred, ...array_filter(
                self::ROUTING_TABLE[TransactionType::SUBSCRIPTION->value],
                fn(PaymentProvider $p) => $p !== $preferred
              )]
            : self::ROUTING_TABLE[TransactionType::SUBSCRIPTION->value];

        $lastException = null;

        foreach ($chain as $provider) {
            $gateway = $this->gateway($provider);

            try {
                $response = $gateway->createSubscription($request);

                Log::info('Subscription created', [
                    'provider' => $provider->value,
                    'user_id' => $request->userId,
                    'plan_code' => $request->planCode,
                ]);

                return $response;
            } catch (PaymentGatewayException $e) {
                $lastException = $e;

                Log::warning('Subscription creation failed', [
                    'provider' => $provider->value,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        throw new AllGatewaysFailedException(
            'All providers failed to create subscription',
            previous: $lastException
        );
    }

    /**
     * Cancel subscription across any provider.
     */
    public function cancelSubscription(
        string $subscriptionCode,
        PaymentProvider $provider
    ): bool {
        return $this->gateway($provider)
            ->cancelSubscription($subscriptionCode);
    }

    // ─── Webhook Processing ────────────────────────────────────────

    /**
     * Process an incoming webhook from any provider.
     */
    public function processWebhook(
        PaymentProvider $provider,
        string $rawPayload,
        string $signature
    ): array {
        $gateway = $this->gateway($provider);

        // 1. Verify signature
        if (! $gateway->verifyWebhookSignature($rawPayload, $signature)) {
            Log::critical('Webhook signature verification failed', [
                'provider' => $provider->value,
            ]);

            throw new PaymentGatewayException(
                "Invalid webhook signature from {$provider->value}"
            );
        }

        // 2. Parse and process
        $payload = new \App\DTOs\Payment\WebhookPayload(
            provider: $provider,
            rawBody: $rawPayload,
            decodedBody: json_decode($rawPayload, true, 512, JSON_THROW_ON_ERROR)
        );

        return $gateway->processWebhook($payload);
    }

    // ─── Private Helpers ───────────────────────────────────────────

    /**
     * Infer transaction type from request context.
     */
    private function inferTransactionType(
        PaymentInitializationRequest $request
    ): TransactionType {
        if ($request->isInternational) {
            return TransactionType::INTERNATIONAL;
        }

        if ($request->planCode !== null) {
            return TransactionType::SUBSCRIPTION;
        }

        if ($request->splitConfig !== null) {
            return TransactionType::RECURRING_SPLIT;
        }

        return TransactionType::ONE_TIME;
    }

    /**
     * Resolve the ordered chain of providers to attempt.
     *
     * Checks circuit breaker state and skips unhealthy providers.
     *
     * @return \Generator<PaymentGatewayInterface>
     */
    private function resolveProviderChain(
        TransactionType $type,
        PaymentInitializationRequest $request
    ): \Generator {
        $chain = self::ROUTING_TABLE[$type->value];

        // Override with explicit preference if valid
        if ($request->preferredProvider !== null) {
            $preferred = $request->preferredProvider;
            $chain = [$preferred, ...array_filter($chain, fn(PaymentProvider $p) => $p !== $preferred)];
        }

        foreach ($chain as $provider) {
            // Circuit breaker: skip providers with recent consecutive failures
            if ($this->isCircuitOpen($provider)) {
                Log::info('Provider circuit breaker is open, skipping', [
                    'provider' => $provider->value,
                ]);
                continue;
            }

            yield $provider;
        }
    }

    /**
     * Simple circuit breaker: skip provider if >5 failures in last 60 seconds.
     */
    private function isCircuitOpen(PaymentProvider $provider): bool
    {
        $key = "payment:circuit:{$provider->value}";
        $failures = (int) Cache::get($key, 0);

        return $failures >= 5;
    }

    /**
     * Record a routing decision for analytics.
     */
    private function recordRoutingDecision(
        TransactionType $type,
        PaymentProvider $provider,
        bool $success
    ): void {
        // In production, dispatch to queue for async analytics
        Log::channel('payments')->info('routing_decision', [
            'type' => $type->value,
            'provider' => $provider->value,
            'success' => $success,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
```

---

## 6. Complete Laravel Implementation

### 6.1 Enums

```php
<?php
// app/Enums/Payment/PaymentProvider.php

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
```

```php
<?php
// app/Enums/Payment/TransactionType.php

declare(strict_types=1);

namespace App\Enums\Payment;

enum TransactionType: string
{
    case SUBSCRIPTION      = 'subscription';
    case RECURRING_SPLIT   = 'recurring_split';
    case ONE_TIME          = 'one_time';
    case INTERNATIONAL     = 'international';
}
```

```php
<?php
// app/Enums/Payment/TransactionStatus.php

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
```

```php
<?php
// app/Enums/Payment/SubscriptionStatus.php

declare(strict_types=1);

namespace App\Enums\Payment;

enum SubscriptionStatus: string
{
    case ACTIVE          = 'active';
    case PAST_DUE        = 'past_due';
    case CANCELLED       = 'cancelled';
    case EXPIRED         = 'expired';
    case PAUSED          = 'paused';
    case TRIAL           = 'trial';
    case NON_RENEWING    = 'non_renewing';

    public function isActive(): bool
    {
        return in_array($this, [self::ACTIVE, self::TRIAL], true);
    }

    public function grantsAccess(): bool
    {
        return $this->isActive() || $this === self::NON_RENEWING;
    }
}
```

### 6.2 Data Transfer Objects

```php
<?php
// app/DTOs/Payment/PaymentInitializationRequest.php

declare(strict_types=1);

namespace App\DTOs\Payment;

use App\Enums\Payment\PaymentProvider;
use App\ValueObjects\Money;

final readonly class PaymentInitializationRequest
{
    public function __construct(
        public string $email,
        public Money $amount,
        public string $reference,
        public ?string $planCode = null,
        public ?string $callbackUrl = null,
        public ?string $description = null,
        public ?array $metadata = null,
        public ?array $channels = null,
        public ?bool $isInternational = false,
        public ?PaymentProvider $preferredProvider = null,
        public ?SplitConfig $splitConfig = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'email'     => $this->email,
            'amount'    => $this->amount->toInt(),  // Paystack expects kobo
            'reference' => $this->reference,
            'currency'  => $this->isInternational ? 'USD' : 'NGN',
        ];

        if ($this->planCode !== null) {
            $data['plan'] = $this->planCode;
        }

        if ($this->callbackUrl !== null) {
            $data['callback_url'] = $this->callbackUrl;
        }

        if ($this->description !== null) {
            $data['description'] = $this->description;
        }

        if ($this->metadata !== null) {
            $data['metadata'] = $this->metadata;
        }

        if ($this->channels !== null) {
            $data['channels'] = $this->channels;
        }

        return $data;
    }
}
```

```php
<?php
// app/DTOs/Payment/PaymentInitializationResponse.php

declare(strict_types=1);

namespace App\DTOs\Payment;

use App\Enums\Payment\{PaymentProvider, TransactionStatus};

final readonly class PaymentInitializationResponse
{
    public function __construct(
        public PaymentProvider $provider,
        public string $reference,
        public string $authorizationUrl,
        public string $accessCode,
        public TransactionStatus $status,
        public ?string $providerTransactionId = null,
        public ?string $message = null,
    ) {}
}
```

```php
<?php
// app/DTOs/Payment/PaymentVerificationResponse.php

declare(strict_types=1);

namespace App\DTOs\Payment;

use App\Enums\Payment\{PaymentProvider, TransactionStatus};
use App\ValueObjects\Money;

final readonly class PaymentVerificationResponse
{
    public function __construct(
        public PaymentProvider $provider,
        public string $reference,
        public TransactionStatus $status,
        public Money $amount,
        public string $currency,
        public string $customerEmail,
        public ?string $providerTransactionId = null,
        public ?string $channel = null,
        public ?string $gatewayResponse = null,
        public ?string $paidAt = null,
        public ?array $metadata = null,
    ) {}
}
```

```php
<?php
// app/DTOs/Payment/SubscriptionCreationRequest.php

declare(strict_types=1);

namespace App\DTOs\Payment;

use App\Enums\Payment\PaymentProvider;

final readonly class SubscriptionCreationRequest
{
    public function __construct(
        public int $userId,
        public string $email,
        public string $planCode,
        public ?string $customerCode = null,
        public ?string $authorizationCode = null,
        public ?PaymentProvider $startAfter = null,
        public ?int $quantity = null,
    ) {}
}
```

```php
<?php
// app/DTOs/Payment/SubscriptionCreationResponse.php

declare(strict_types=1);

namespace App\DTOs\Payment;

use App\Enums\Payment\{PaymentProvider, SubscriptionStatus};

final readonly class SubscriptionCreationResponse
{
    public function __construct(
        public PaymentProvider $provider,
        public string $subscriptionCode,
        public string $planCode,
        public SubscriptionStatus $status,
        public ?string $nextPaymentDate = null,
        public ?string $createdAt = null,
    ) {}
}
```

```php
<?php
// app/DTOs/Payment/SubscriptionStatusResponse.php

declare(strict_types=1);

namespace App\DTOs\Payment;

use App\Enums\Payment\{PaymentProvider, SubscriptionStatus};

final readonly class SubscriptionStatusResponse
{
    public function __construct(
        public PaymentProvider $provider,
        public string $subscriptionCode,
        public SubscriptionStatus $status,
        public ?string $nextPaymentDate = null,
        public ?string $cancelDate = null,
        public ?string $createdAt = null,
        public ?array $plan = null,
    ) {}
}
```

```php
<?php
// app/DTOs/Payment/PlanCreationRequest.php

declare(strict_types=1);

namespace App\DTOs\Payment;

use App\Enums\Payment\PaymentProvider;
use App\ValueObjects\Money;

final readonly class PlanCreationRequest
{
    public function __construct(
        public string $name,
        public Money $amount,
        public string $interval, // 'daily', 'monthly', 'annually'
        public ?string $description = null,
        public ?int $invoiceLimit = null,
        public ?bool $sendInvoices = true,
        public ?PaymentProvider $provider = null,
    ) {}
}
```

```php
<?php
// app/DTOs/Payment/PlanCreationResponse.php

declare(strict_types=1);

namespace App\DTOs\Payment;

use App\Enums\Payment\PaymentProvider;

final readonly class PlanCreationResponse
{
    public function __construct(
        public PaymentProvider $provider,
        public string $planCode,
        public string $name,
        public int $amount,  // in kobo
        public string $interval,
        public ?string $description = null,
    ) {}
}
```

```php
<?php
// app/DTOs/Payment/CustomerCreationRequest.php

declare(strict_types=1);

namespace App\DTOs\Payment;

final readonly class CustomerCreationRequest
{
    public function __construct(
        public string $email,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $phone = null,
        public ?array $metadata = null,
    ) {}
}
```

```php
<?php
// app/DTOs/Payment/CustomerCreationResponse.php

declare(strict_types=1);

namespace App\DTOs\Payment;

use App\Enums\Payment\PaymentProvider;

final readonly class CustomerCreationResponse
{
    public function __construct(
        public PaymentProvider $provider,
        public string $customerCode,
        public string $email,
        public ?int $providerId = null,
    ) {}
}
```

```php
<?php
// app/DTOs/Payment/SplitCreationRequest.php

declare(strict_types=1);

namespace App\DTOs\Payment;

final readonly class SplitCreationRequest
{
    /**
     * @param array<int, array{subaccount: string, share: int}> $subAccounts
     */
    public function __construct(
        public string $name,
        public string $type,        // 'percentage' or 'flat'
        public array $subAccounts,
        public ?int $bearerSubAccount = null,
        public ?bool $bearerFee = false,
    ) {}
}
```

```php
<?php
// app/DTOs/Payment/SplitCreationResponse.php

declare(strict_types=1);

namespace App\DTOs\Payment;

use App\Enums\Payment\PaymentProvider;

final readonly class SplitCreationResponse
{
    public function __construct(
        public PaymentProvider $provider,
        public string $splitCode,
        public string $name,
        public string $type,
    ) {}
}
```

```php
<?php
// app/DTOs/Payment/WebhookPayload.php

declare(strict_types=1);

namespace App\DTOs\Payment;

use App\Enums\Payment\PaymentProvider;

final readonly class WebhookPayload
{
    public function __construct(
        public PaymentProvider $provider,
        public string $rawBody,
        public array $decodedBody,
    ) {
    }

    public function event(): string
    {
        return $this->decodedBody['event'] ?? '';
    }

    public function data(): array
    {
        return $this->decodedBody['data'] ?? [];
    }
}
```

```php
<?php
// app/DTOs/Payment/SplitConfig.php

declare(strict_types=1);

namespace App\DTOs\Payment;

final readonly class SplitConfig
{
    public function __construct(
        public string $splitCode,
        public int $percentage, // percentage for BLOSSOM (remainder goes to vendor)
    ) {}
}
```

### 6.3 Value Objects

```php
<?php
// app/ValueObjects/Money.php

declare(strict_types=1);

namespace App\ValueObjects;

final readonly class Money
{
    public function __construct(
        private int $amount,   // In the smallest currency unit (kobo/cents)
        private string $currency = 'NGN',
    ) {
        if ($this->amount < 0) {
            throw new \InvalidArgumentException('Money amount cannot be negative');
        }
    }

    /**
     * Create from major units (naira/dollars).
     */
    public static function fromNaira(float $naira): self
    {
        return new self((int) round($naira * 100));
    }

    public static function fromKobo(int $kobo): self
    {
        return new self($kobo);
    }

    /**
     * Get amount in kobo (smallest unit).
     */
    public function toInt(): int
    {
        return $this->amount;
    }

    /**
     * Get amount in naira (major unit).
     */
    public function toNaira(): float
    {
        return $this->amount / 100;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function formatted(): string
    {
        return $this->currency . ' ' . number_format($this->toNaira(), 2);
    }
}
```

### 6.4 Exceptions

```php
<?php
// app/Exceptions/Payment/PaymentGatewayException.php

declare(strict_types=1);

namespace App\Exceptions\Payment;

use RuntimeException;

class PaymentGatewayException extends RuntimeException
{
    public static function connectionFailed(string $provider, string $message): static
    {
        return new static("Connection failed for {$provider}: {$message}");
    }

    public static function validationFailed(string $provider, string $message): static
    {
        return new static("Validation failed for {$provider}: {$message}");
    }
}
```

```php
<?php
// app/Exceptions/Payment/AllGatewaysFailedException.php

declare(strict_types=1);

namespace App\Exceptions\Payment;

class AllGatewaysFailedException extends PaymentGatewayException {}
```

```php
<?php
// app/Exceptions/Payment/TransactionNotFoundException.php

declare(strict_types=1);

namespace App\Exceptions\Payment;

class TransactionNotFoundException extends PaymentGatewayException
{
    public static function forReference(string $reference): static
    {
        return new static("Transaction not found for reference: {$reference}");
    }
}
```

### 6.5 Paystack Gateway Implementation

```php
<?php
// app/Services/Payment/PaystackGateway.php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\DTOs\Payment\{
    CustomerCreationRequest,
    CustomerCreationResponse,
    PaymentInitializationRequest,
    PaymentInitializationResponse,
    PaymentVerificationResponse,
    PlanCreationRequest,
    PlanCreationResponse,
    SplitCreationRequest,
    SplitCreationResponse,
    SubscriptionCreationRequest,
    SubscriptionCreationResponse,
    SubscriptionStatusResponse,
    WebhookPayload
};
use App\Enums\Payment\{PaymentProvider, TransactionStatus, SubscriptionStatus};
use App\Exceptions\Payment\{PaymentGatewayException, TransactionNotFoundException};
use App\ValueObjects\Money;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackGateway implements PaymentGatewayInterface
{
    private const BASE_URL = 'https://api.paystack.co';

    private string $secretKey;
    private string $publicKey;
    private string $webhookSecret;

    public function __construct()
    {
        $this->secretKey    = config('paystack.secret_key', '');
        $this->publicKey    = config('paystack.public_key', '');
        $this->webhookSecret = config('paystack.webhook_secret', '');
    }

    public function getProvider(): PaymentProvider
    {
        return PaymentProvider::PAYSTACK;
    }

    // ─── Transaction Lifecycle ──────────────────────────────────────

    public function initializePayment(
        PaymentInitializationRequest $request
    ): PaymentInitializationResponse {
        $payload = $request->toArray();

        // Add Paystack-specific metadata
        $payload['metadata'] = array_merge(
            $payload['metadata'] ?? [],
            ['provider' => 'paystack']
        );

        $response = $this->client()
            ->post('/transaction/initialize', $payload)
            ->throw();

        $body = $response->json();

        return new PaymentInitializationResponse(
            provider: PaymentProvider::PAYSTACK,
            reference: $body['data']['reference'],
            authorizationUrl: $body['data']['authorization_url'],
            accessCode: $body['data']['access_code'],
            status: TransactionStatus::PENDING,
            message: $body['message'] ?? null,
        );
    }

    public function verifyTransaction(
        string $reference
    ): PaymentVerificationResponse {
        $response = $this->client()
            ->get("/transaction/verify/{$reference}")
            ->throw();

        $body = $response->json();
        $data = $body['data'];

        $status = match ($data['status']) {
            'success' => TransactionStatus::SUCCESS,
            'abandoned', 'failed' => TransactionStatus::FAILED,
            'reversed' => TransactionStatus::REFUNDED,
            default => TransactionStatus::PROCESSING,
        };

        return new PaymentVerificationResponse(
            provider: PaymentProvider::PAYSTACK,
            reference: $data['reference'],
            status: $status,
            amount: Money::fromKobo($data['amount']),
            currency: $data['currency'],
            customerEmail: $data['customer']['email'],
            providerTransactionId: (string) $data['id'],
            channel: $data['channel'] ?? null,
            gatewayResponse: $data['gateway_response'] ?? null,
            paidAt: $data['paid_at'] ?? null,
            metadata: $data['metadata'] ?? null,
        );
    }

    public function fetchTransaction(
        string $providerTransactionId
    ): PaymentVerificationResponse {
        $response = $this->client()
            ->get("/transaction/{$providerTransactionId}")
            ->throw();

        $data = $response->json()['data'];

        $status = match ($data['status']) {
            'success' => TransactionStatus::SUCCESS,
            'abandoned', 'failed' => TransactionStatus::FAILED,
            'reversed' => TransactionStatus::REFUNDED,
            default => TransactionStatus::PROCESSING,
        };

        return new PaymentVerificationResponse(
            provider: PaymentProvider::PAYSTACK,
            reference: $data['reference'],
            status: $status,
            amount: Money::fromKobo($data['amount']),
            currency: $data['currency'],
            customerEmail: $data['customer']['email'],
            providerTransactionId: (string) $data['id'],
            channel: $data['channel'] ?? null,
            gatewayResponse: $data['gateway_response'] ?? null,
            paidAt: $data['paid_at'] ?? null,
            metadata: $data['metadata'] ?? null,
        );
    }

    // ─── Plans ─────────────────────────────────────────────────────

    public function createPlan(
        PlanCreationRequest $request
    ): PlanCreationResponse {
        $response = $this->client()
            ->post('/plan', [
                'name'          => $request->name,
                'amount'        => $request->amount->toInt(),
                'interval'      => $request->interval,
                'description'   => $request->description,
                'invoice_limit' => $request->invoiceLimit,
            ])
            ->throw();

        $data = $response->json()['data'];

        return new PlanCreationResponse(
            provider: PaymentProvider::PAYSTACK,
            planCode: $data['plan_code'],
            name: $data['name'],
            amount: $data['amount'],
            interval: $data['interval'],
            description: $data['description'] ?? null,
        );
    }

    public function fetchPlan(string $planCode): PlanCreationResponse
    {
        $response = $this->client()
            ->get("/plan/{$planCode}")
            ->throw();

        $data = $response->json()['data'];

        return new PlanCreationResponse(
            provider: PaymentProvider::PAYSTACK,
            planCode: $data['plan_code'],
            name: $data['name'],
            amount: $data['amount'],
            interval: $data['interval'],
            description: $data['description'] ?? null,
        );
    }

    // ─── Subscriptions ─────────────────────────────────────────────

    public function createSubscription(
        SubscriptionCreationRequest $request
    ): SubscriptionCreationResponse {
        $payload = [
            'customer' => $request->email,
            'plan'     => $request->planCode,
        ];

        if ($request->authorizationCode !== null) {
            $payload['authorization'] = $request->authorizationCode;
        }

        if ($request->quantity !== null) {
            $payload['quantity'] = $request->quantity;
        }

        if ($request->startAfter !== null) {
            $payload['start_date'] = now()->addMonth()->startOfMonth()->toDateTimeString();
        }

        $response = $this->client()
            ->post('/subscription', $payload)
            ->throw();

        $data = $response->json()['data'];

        return new SubscriptionCreationResponse(
            provider: PaymentProvider::PAYSTACK,
            subscriptionCode: $data['subscription_code'],
            planCode: $data['plan']['plan_code'] ?? $request->planCode,
            status: SubscriptionStatus::ACTIVE,
            nextPaymentDate: $data['next_payment_date'] ?? null,
            createdAt: $data['createdAt'] ?? null,
        );
    }

    public function fetchSubscriptionStatus(
        string $subscriptionCode
    ): SubscriptionStatusResponse {
        $response = $this->client()
            ->get("/subscription/{$subscriptionCode}")
            ->throw();

        $data = $response->json()['data'];

        $status = match ($data['status']) {
            'active'       => SubscriptionStatus::ACTIVE,
            'past_due'     => SubscriptionStatus::PAST_DUE,
            'cancelled'    => SubscriptionStatus::CANCELLED,
            'completed'    => SubscriptionStatus::EXPIRED,
            'non-renewing' => SubscriptionStatus::NON_RENEWING,
            default        => SubscriptionStatus::ACTIVE,
        };

        return new SubscriptionStatusResponse(
            provider: PaymentProvider::PAYSTACK,
            subscriptionCode: $data['subscription_code'],
            status: $status,
            nextPaymentDate: $data['next_payment_date'] ?? null,
            cancelDate: $data['cancel_date'] ?? null,
            createdAt: $data['createdAt'] ?? null,
            plan: $data['plan'] ?? null,
        );
    }

    public function cancelSubscription(
        string $subscriptionCode
    ): bool {
        $response = $this->client()
            ->post('/subscription/disable', [
                'code' => $subscriptionCode,
                'token' => $this->getSubscriptionToken($subscriptionCode),
            ])
            ->throw();

        return $response->json()['status'] === true;
    }

    public function enableSubscription(
        string $subscriptionCode
    ): bool {
        $response = $this->client()
            ->post('/subscription/enable', [
                'code' => $subscriptionCode,
                'token' => $this->getSubscriptionToken($subscriptionCode),
            ])
            ->throw();

        return $response->json()['status'] === true;
    }

    // ─── Customers ─────────────────────────────────────────────────

    public function createCustomer(
        CustomerCreationRequest $request
    ): CustomerCreationResponse {
        $response = $this->client()
            ->post('/customer', [
                'email'     => $request->email,
                'first_name' => $request->firstName,
                'last_name'  => $request->lastName,
                'phone'      => $request->phone,
                'metadata'   => $request->metadata,
            ])
            ->throw();

        $data = $response->json()['data'];

        return new CustomerCreationResponse(
            provider: PaymentProvider::PAYSTACK,
            customerCode: $data['customer_code'],
            email: $data['email'],
            providerId: $data['id'] ?? null,
        );
    }

    // ─── Split Payments ────────────────────────────────────────────

    public function createSplit(
        SplitCreationRequest $request
    ): SplitCreationResponse {
        $response = $this->client()
            ->post('/split', [
                'name'          => $request->name,
                'type'          => $request->type,
                'sub_accounts'  => $request->subAccounts,
                'bearer_sub_account' => $request->bearerSubAccount,
                'bearer_fee'    => $request->bearerFee,
            ])
            ->throw();

        $data = $response->json()['data'];

        return new SplitCreationResponse(
            provider: PaymentProvider::PAYSTACK,
            splitCode: $data['split_code'],
            name: $data['name'],
            type: $data['type'],
        );
    }

    // ─── Webhook Processing ────────────────────────────────────────

    public function verifyWebhookSignature(
        string $payload,
        string $signature
    ): bool {
        $expected = hash_hmac('sha512', $payload, $this->webhookSecret);

        return hash_equals($expected, $signature);
    }

    public function processWebhook(
        WebhookPayload $payload
    ): array {
        $event = $payload->event();
        $data  = $payload->data();

        Log::info('Paystack webhook received', [
            'event' => $event,
            'reference' => $data['reference'] ?? null,
        ]);

        return match ($event) {
            'charge.success' => $this->handleChargeSuccess($data),
            'charge.failed' => $this->handleChargeFailed($data),
            'invoice.created' => $this->handleInvoiceCreated($data),
            'invoice.payment_failed' => $this->handleInvoicePaymentFailed($data),
            'invoice.updated' => $this->handleInvoiceUpdated($data),
            'subscription.create' => $this->handleSubscriptionCreated($data),
            'subscription.disable' => $this->handleSubscriptionDisabled($data),
            'subscription.not_renewing' => $this->handleSubscriptionNotRenewing($data),
            'subscription.expired' => $this->handleSubscriptionExpired($data),
            default => [
                'event' => $event,
                'data' => $data,
                'processed' => false,
            ],
        };
    }

    // ─── Webhook Event Handlers ────────────────────────────────────

    private function handleChargeSuccess(array $data): array
    {
        $reference = $data['reference'] ?? null;

        if ($reference === null) {
            return ['event' => 'charge.success', 'data' => $data, 'processed' => false];
        }

        // Dispatch to queue for async processing
        \App\Jobs\Payment\ProcessSuccessfulPayment::dispatch([
            'provider' => 'paystack',
            'reference' => $reference,
            'transaction_id' => $data['id'] ?? null,
            'amount' => $data['amount'] ?? 0,
            'customer_email' => $data['customer']['email'] ?? null,
            'metadata' => $data['metadata'] ?? [],
            'paid_at' => $data['paid_at'] ?? null,
        ]);

        return ['event' => 'charge.success', 'data' => $data, 'processed' => true];
    }

    private function handleChargeFailed(array $data): array
    {
        $reference = $data['reference'] ?? null;

        if ($reference !== null) {
            \App\Jobs\Payment\ProcessFailedPayment::dispatch([
                'provider' => 'paystack',
                'reference' => $reference,
                'error' => $data['gateway_response'] ?? 'Unknown error',
            ]);
        }

        return ['event' => 'charge.failed', 'data' => $data, 'processed' => true];
    }

    private function handleInvoiceCreated(array $data): array
    {
        \App\Jobs\Payment\LogUpcomingRenewal::dispatch([
            'provider' => 'paystack',
            'subscription_code' => $data['subscription']['subscription_code'] ?? null,
            'amount' => $data['amount'] ?? 0,
            'due_date' => $data['due_date'] ?? null,
        ]);

        return ['event' => 'invoice.created', 'data' => $data, 'processed' => true];
    }

    private function handleInvoicePaymentFailed(array $data): array
    {
        \App\Jobs\Payment\ProcessDunningStep::dispatch([
            'provider' => 'paystack',
            'subscription_code' => $data['subscription']['subscription_code'] ?? null,
            'invoice_code' => $data['invoice_code'] ?? null,
        ]);

        return ['event' => 'invoice.payment_failed', 'data' => $data, 'processed' => true];
    }

    private function handleInvoiceUpdated(array $data): array
    {
        return ['event' => 'invoice.updated', 'data' => $data, 'processed' => true];
    }

    private function handleSubscriptionCreated(array $data): array
    {
        return ['event' => 'subscription.create', 'data' => $data, 'processed' => true];
    }

    private function handleSubscriptionDisabled(array $data): array
    {
        $subscriptionCode = $data['subscription_code'] ?? null;

        if ($subscriptionCode !== null) {
            \App\Jobs\Payment\ProcessSubscriptionCancellation::dispatch([
                'provider' => 'paystack',
                'subscription_code' => $subscriptionCode,
            ]);
        }

        return ['event' => 'subscription.disable', 'data' => $data, 'processed' => true];
    }

    private function handleSubscriptionNotRenewing(array $data): array
    {
        $subscriptionCode = $data['subscription_code'] ?? null;

        if ($subscriptionCode !== null) {
            \App\Jobs\Payment\MarkSubscriptionAsNonRenewing::dispatch([
                'provider' => 'paystack',
                'subscription_code' => $subscriptionCode,
            ]);
        }

        return ['event' => 'subscription.not_renewing', 'data' => $data, 'processed' => true];
    }

    private function handleSubscriptionExpired(array $data): array
    {
        $subscriptionCode = $data['subscription_code'] ?? null;

        if ($subscriptionCode !== null) {
            \App\Jobs\Payment\ProcessSubscriptionExpiration::dispatch([
                'provider' => 'paystack',
                'subscription_code' => $subscriptionCode,
            ]);
        }

        return ['event' => 'subscription.expired', 'data' => $data, 'processed' => true];
    }

    // ─── Private Helpers ───────────────────────────────────────────

    private function client(): PendingRequest
    {
        return Http::withToken($this->secretKey)
            ->acceptJson()
            ->timeout(30)
            ->retry(2, 500, function (\Throwable $exception, PendingRequest $request) {
                return $exception instanceof ConnectionException;
            })
            ->baseUrl(self::BASE_URL);
    }

    /**
     * Retrieve the subscription token needed for enable/disable.
     * Paystack requires the subscription token for state changes.
     */
    private function getSubscriptionToken(string $subscriptionCode): string
    {
        // In production, fetch from local DB cache or Paystack API
        $subscription = \App\Models\Subscription::where(
            'provider_subscription_code', $subscriptionCode
        )->first();

        return $subscription?->provider_token ?? '';
    }
}
```

### 6.6 Webhook Controller

```php
<?php
// app/Http/Controllers/Webhooks/PaystackWebhookController.php

declare(strict_types=1);

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentService;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\Log;

class PaystackWebhookController extends Controller
{
    public function __construct(
        private PaymentService $paymentService,
    ) {}

    /**
     * Handle incoming Paystack webhook.
     *
     * Paystack sends:
     *   Header: x-paystack-signature (HMAC SHA512)
     *   Body:   JSON { event, data }
     */
    public function __invoke(Request $request): JsonResponse
    {
        $signature = $request->header('x-paystack-signature');
        $rawBody   = $request->getContent();

        if ($signature === null) {
            Log::critical('Paystack webhook missing signature header');

            return response()->json(['error' => 'Missing signature'], 400);
        }

        try {
            $result = $this->paymentService->processWebhook(
                provider: \App\Enums\Payment\PaymentProvider::PAYSTACK,
                rawPayload: $rawBody,
                signature: $signature,
            );

            return response()->json([
                'status' => 'success',
                'event' => $result['event'],
                'processed' => $result['processed'],
            ]);
        } catch (\App\Exceptions\Payment\PaymentGatewayException $e) {
            Log::critical('Paystack webhook processing failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'Processing failed'], 422);
        }
    }
}
```

### 6.7 Nomba Gateway (Simplified)

```php
<?php
// app/Services/Payment/NombaGateway.php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\DTOs\Payment\{
    CustomerCreationRequest,
    CustomerCreationResponse,
    PaymentInitializationRequest,
    PaymentInitializationResponse,
    PaymentVerificationResponse,
    PlanCreationRequest,
    PlanCreationResponse,
    SplitCreationRequest,
    SplitCreationResponse,
    SubscriptionCreationRequest,
    SubscriptionCreationResponse,
    SubscriptionStatusResponse,
    WebhookPayload
};
use App\Enums\Payment\{PaymentProvider, TransactionStatus, SubscriptionStatus};
use App\ValueObjects\Money;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NombaGateway implements PaymentGatewayInterface
{
    private const BASE_URL = 'https://api.nomba.com/v1';

    private string $apiKey;
    private string $merchantId;
    private string $webhookSecret;

    public function __construct()
    {
        $this->apiKey       = config('nomba.api_key', '');
        $this->merchantId   = config('nomba.merchant_id', '');
        $this->webhookSecret = config('nomba.webhook_secret', '');
    }

    public function getProvider(): PaymentProvider
    {
        return PaymentProvider::NOMBA;
    }

    public function initializePayment(
        PaymentInitializationRequest $request
    ): PaymentInitializationResponse {
        $response = $this->client()
            ->post('/payments/init', [
                'amount' => $request->amount->toInt(),
                'currency' => 'NGN',
                'reference' => $request->reference,
                'customer' => [
                    'email' => $request->email,
                ],
                'paymentMethod' => ['type' => 'card'],
                'callbackUrl' => $request->callbackUrl,
                'metadata' => $request->metadata,
            ])
            ->throw();

        $body = $response->json();

        return new PaymentInitializationResponse(
            provider: PaymentProvider::NOMBA,
            reference: $body['data']['reference'] ?? $request->reference,
            authorizationUrl: $body['data']['paymentUrl'] ?? '',
            accessCode: $body['data']['token'] ?? '',
            status: TransactionStatus::PENDING,
            message: $body['message'] ?? null,
        );
    }

    public function verifyTransaction(
        string $reference
    ): PaymentVerificationResponse {
        $response = $this->client()
            ->get("/payments/{$reference}")
            ->throw();

        $data = $response->json()['data'];

        $status = match ($data['status']) {
            'successful' => TransactionStatus::SUCCESS,
            'failed' => TransactionStatus::FAILED,
            'reversed' => TransactionStatus::REFUNDED,
            default => TransactionStatus::PROCESSING,
        };

        return new PaymentVerificationResponse(
            provider: PaymentProvider::NOMBA,
            reference: $data['reference'] ?? $reference,
            status: $status,
            amount: Money::fromKobo((int) ($data['amount'] ?? 0)),
            currency: $data['currency'] ?? 'NGN',
            customerEmail: $data['customer']['email'] ?? '',
            providerTransactionId: $data['transactionId'] ?? null,
            channel: $data['paymentMethod']['type'] ?? null,
            gatewayResponse: $data['responseMessage'] ?? null,
            paidAt: $data['paidAt'] ?? null,
            metadata: $data['metadata'] ?? null,
        );
    }

    public function fetchTransaction(
        string $providerTransactionId
    ): PaymentVerificationResponse {
        return $this->verifyTransaction($providerTransactionId);
    }

    public function createPlan(
        PlanCreationRequest $request
    ): PlanCreationResponse {
        // Nomba doesn't have native plans — we implement on our side
        $planCode = 'nomba_' . $request->name;

        Log::info('Nomba plan created locally (no native plans API)', [
            'plan_code' => $planCode,
            'name' => $request->name,
        ]);

        return new PlanCreationResponse(
            provider: PaymentProvider::NOMBA,
            planCode: $planCode,
            name: $request->name,
            amount: $request->amount->toInt(),
            interval: $request->interval,
            description: $request->description,
        );
    }

    public function fetchPlan(string $planCode): PlanCreationResponse
    {
        // Retrieve from local cache/DB since Nomba has no native plan API
        throw new \LogicException('Nomba plans are managed locally. Use Plan model.');
    }

    public function createSubscription(
        SubscriptionCreationRequest $request
    ): SubscriptionCreationResponse {
        // Nomba doesn't support auto-renewing subscriptions.
        // We use charge_authorization pattern: save card token, charge on schedule.
        Log::info('Nomba subscription: manual renewal pattern (no auto-charge)', [
            'email' => $request->email,
            'plan_code' => $request->planCode,
        ]);

        return new SubscriptionCreationResponse(
            provider: PaymentProvider::NOMBA,
            subscriptionCode: 'nomba_manual_' . uniqid(),
            planCode: $request->planCode,
            status: SubscriptionStatus::ACTIVE,
        );
    }

    public function fetchSubscriptionStatus(
        string $subscriptionCode
    ): SubscriptionStatusResponse {
        // Local lookup
        $subscription = \App\Models\Subscription::where(
            'provider_subscription_code', $subscriptionCode
        )->first();

        return new SubscriptionStatusResponse(
            provider: PaymentProvider::NOMBA,
            subscriptionCode: $subscriptionCode,
            status: $subscription
                ? SubscriptionStatus::from($subscription->status)
                : SubscriptionStatus::EXPIRED,
        );
    }

    public function cancelSubscription(
        string $subscriptionCode
    ): bool {
        $subscription = \App\Models\Subscription::where(
            'provider_subscription_code', $subscriptionCode
        )->first();

        if ($subscription) {
            $subscription->update(['status' => SubscriptionStatus::CANCELLED->value]);
        }

        return true;
    }

    public function enableSubscription(
        string $subscriptionCode
    ): bool {
        throw new \LogicException(
            'Nomba does not support subscription reactivation. Create new subscription.'
        );
    }

    public function createCustomer(
        CustomerCreationRequest $request
    ): CustomerCreationResponse {
        return new CustomerCreationResponse(
            provider: PaymentProvider::NOMBA,
            customerCode: 'nomba_' . md5($request->email),
            email: $request->email,
        );
    }

    public function createSplit(
        SplitCreationRequest $request
    ): SplitCreationResponse {
        throw new PaymentGatewayException(
            'Nomba does not support split payments. Use Monnify or Paystack.'
        );
    }

    public function verifyWebhookSignature(
        string $payload,
        string $signature
    ): bool {
        $expected = hash_hmac('sha512', $payload, $this->webhookSecret);

        return hash_equals($expected, $signature);
    }

    public function processWebhook(
        WebhookPayload $payload
    ): array {
        $event = $payload->event();
        $data  = $payload->data();

        Log::info('Nomba webhook received', ['event' => $event]);

        return match ($event) {
            'payment.success' => [
                'event' => $event,
                'data' => $data,
                'processed' => true,
            ],
            default => [
                'event' => $event,
                'data' => $data,
                'processed' => false,
            ],
        };
    }

    private function client(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => $this->apiKey,
            'merchantid' => $this->merchantId,
        ])
            ->acceptJson()
            ->timeout(30)
            ->baseUrl(self::BASE_URL);
    }
}
```

### 6.8 Monnify Gateway (Simplified)

```php
<?php
// app/Services/Payment/MonnifyGateway.php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\DTOs\Payment\{
    CustomerCreationRequest,
    CustomerCreationResponse,
    PaymentInitializationRequest,
    PaymentInitializationResponse,
    PaymentVerificationResponse,
    PlanCreationRequest,
    PlanCreationResponse,
    SplitCreationRequest,
    SplitCreationResponse,
    SubscriptionCreationRequest,
    SubscriptionCreationResponse,
    SubscriptionStatusResponse,
    WebhookPayload
};
use App\Enums\Payment\{PaymentProvider, TransactionStatus, SubscriptionStatus};
use App\ValueObjects\Money;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonnifyGateway implements PaymentGatewayInterface
{
    private const BASE_URL = 'https://api.monnify.com';

    private string $apiKey;
    private string $secretKey;
    private string $contractCode;
    private string $webhookSecret;

    public function __construct()
    {
        $this->apiKey        = config('monnify.api_key', '');
        $this->secretKey     = config('monnify.secret_key', '');
        $this->contractCode  = config('monnify.contract_code', '');
        $this->webhookSecret = config('monnify.webhook_secret', '');
    }

    public function getProvider(): PaymentProvider
    {
        return PaymentProvider::MONNIFY;
    }

    public function initializePayment(
        PaymentInitializationRequest $request
    ): PaymentInitializationResponse {
        $payload = [
            'amount' => $request->amount->toNaira(),
            'customerName' => $request->metadata['customer_name'] ?? '',
            'customerEmail' => $request->email,
            'paymentReference' => $request->reference,
            'paymentDescription' => $request->description ?? 'BLOSSOM Payment',
            'contractCode' => $this->contractCode,
            'currencyCode' => 'NGN',
            'redirectUrl' => $request->callbackUrl,
        ];

        if ($request->splitConfig !== null) {
            $payload['paymentSplit'] = [
                [
                    'subAccountCode' => $request->splitConfig->splitCode,
                    'percentage' => 100 - $request->splitConfig->percentage,
                ],
            ];
        }

        $response = $this->client()
            ->post('/api/v1/merchant/transactions/init-transaction', $payload)
            ->throw();

        $body = $response->json()['responseBody'] ?? $response->json();

        return new PaymentInitializationResponse(
            provider: PaymentProvider::MONNIFY,
            reference: $request->reference,
            authorizationUrl: $body['paymentUrl'] ?? '',
            accessCode: $body['transactionReference'] ?? '',
            status: TransactionStatus::PENDING,
            message: $response->json()['responseMessage'] ?? null,
        );
    }

    public function verifyTransaction(
        string $reference
    ): PaymentVerificationResponse {
        $response = $this->client()
            ->get("/api/v2/transactions/{$reference}")
            ->throw();

        $data = $response->json()['responseBody'] ?? $response->json();

        $status = match ($data['transactionStatus']) {
            'SUCCESS' => TransactionStatus::SUCCESS,
            'FAILED' => TransactionStatus::FAILED,
            'REVERSED' => TransactionStatus::REFUNDED,
            default => TransactionStatus::PROCESSING,
        };

        return new PaymentVerificationResponse(
            provider: PaymentProvider::MONNIFY,
            reference: $data['paymentReference'] ?? $reference,
            status: $status,
            amount: Money::fromNaira((float) ($data['amountPaid'] ?? 0)),
            currency: $data['currency'] ?? 'NGN',
            customerEmail: $data['customerEmail'] ?? '',
            providerTransactionId: $data['transactionReference'] ?? null,
            channel: $data['paymentMethod'] ?? null,
            gatewayResponse: $data['messageOnReceipt'] ?? null,
            paidAt: $data['paidOn'] ?? null,
            metadata: json_decode($data['metadata'] ?? '{}', true),
        );
    }

    public function fetchTransaction(
        string $providerTransactionId
    ): PaymentVerificationResponse {
        return $this->verifyTransaction($providerTransactionId);
    }

    public function createPlan(
        PlanCreationRequest $request
    ): PlanCreationResponse {
        $response = $this->client()
            ->post('/api/v1/merchant/plans', [
                'amount' => $request->amount->toNaira(),
                'name' => $request->name,
                'interval' => $request->interval,
                'description' => $request->description,
                'contractCode' => $this->contractCode,
            ])
            ->throw();

        $data = $response->json()['responseBody'] ?? [];

        return new PlanCreationResponse(
            provider: PaymentProvider::MONNIFY,
            planCode: $data['planCode'] ?? uniqid('mnfy_'),
            name: $data['name'] ?? $request->name,
            amount: (int) (($data['amount'] ?? 0) * 100),
            interval: $data['interval'] ?? $request->interval,
            description: $data['description'] ?? null,
        );
    }

    public function fetchPlan(string $planCode): PlanCreationResponse
    {
        $response = $this->client()
            ->get("/api/v1/merchant/plans/{$planCode}")
            ->throw();

        $data = $response->json()['responseBody'] ?? [];

        return new PlanCreationResponse(
            provider: PaymentProvider::MONNIFY,
            planCode: $data['planCode'] ?? $planCode,
            name: $data['name'] ?? '',
            amount: (int) (($data['amount'] ?? 0) * 100),
            interval: $data['interval'] ?? '',
            description: $data['description'] ?? null,
        );
    }

    public function createSubscription(
        SubscriptionCreationRequest $request
    ): SubscriptionCreationResponse {
        $response = $this->client()
            ->post('/api/v1/subscriptions', [
                'customerEmail' => $request->email,
                'planCode' => $request->planCode,
                'contractCode' => $this->contractCode,
            ])
            ->throw();

        $data = $response->json()['responseBody'] ?? [];

        return new SubscriptionCreationResponse(
            provider: PaymentProvider::MONNIFY,
            subscriptionCode: $data['subscriptionCode'] ?? uniqid('mnsub_'),
            planCode: $data['planCode'] ?? $request->planCode,
            status: SubscriptionStatus::ACTIVE,
            nextPaymentDate: $data['nextPaymentDate'] ?? null,
        );
    }

    public function fetchSubscriptionStatus(
        string $subscriptionCode
    ): SubscriptionStatusResponse {
        $response = $this->client()
            ->get("/api/v1/subscriptions/{$subscriptionCode}")
            ->throw();

        $data = $response->json()['responseBody'] ?? [];

        $status = match ($data['status']) {
            'ACTIVE' => SubscriptionStatus::ACTIVE,
            'EXPIRED' => SubscriptionStatus::EXPIRED,
            'CANCELLED' => SubscriptionStatus::CANCELLED,
            default => SubscriptionStatus::ACTIVE,
        };

        return new SubscriptionStatusResponse(
            provider: PaymentProvider::MONNIFY,
            subscriptionCode: $data['subscriptionCode'] ?? $subscriptionCode,
            status: $status,
            nextPaymentDate: $data['nextPaymentDate'] ?? null,
            createdAt: $data['createdAt'] ?? null,
        );
    }

    public function cancelSubscription(
        string $subscriptionCode
    ): bool {
        $response = $this->client()
            ->delete("/api/v1/subscriptions/{$subscriptionCode}")
            ->throw();

        return $response->json()['responseBody'] !== null;
    }

    public function enableSubscription(
        string $subscriptionCode
    ): bool {
        $response = $this->client()
            ->post("/api/v1/subscriptions/{$subscriptionCode}/activate")
            ->throw();

        return $response->json()['responseBody'] !== null;
    }

    public function createCustomer(
        CustomerCreationRequest $request
    ): CustomerCreationResponse {
        return new CustomerCreationResponse(
            provider: PaymentProvider::MONNIFY,
            customerCode: 'mnfy_' . md5($request->email),
            email: $request->email,
        );
    }

    public function createSplit(
        SplitCreationRequest $request
    ): SplitCreationResponse {
        $response = $this->client()
            ->post('/api/v1/sub-accounts', [
                'accountReference' => $request->name,
                'accountName' => $request->name,
                'currencyCode' => 'NGN',
                'contractCode' => $this->contractCode,
                'splitConfig' => [
                    'type' => $request->type,
                    'splitValue' => $request->subAccounts[0]['share'] ?? 0,
                ],
            ])
            ->throw();

        $data = $response->json()['responseBody'] ?? [];

        return new SplitCreationResponse(
            provider: PaymentProvider::MONNIFY,
            splitCode: $data['subAccountCode'] ?? uniqid('mnsplit_'),
            name: $request->name,
            type: $request->type,
        );
    }

    public function verifyWebhookSignature(
        string $payload,
        string $signature
    ): bool {
        $expected = hash_hmac('sha512', $payload, $this->webhookSecret);

        return hash_equals($expected, $signature);
    }

    public function processWebhook(
        WebhookPayload $payload
    ): array {
        $event = $payload->event();
        $data  = $payload->data();

        Log::info('Monnify webhook received', ['event' => $event]);

        return match ($event) {
            'SUCCESSFUL' => [
                'event' => 'payment.success',
                'data' => $data,
                'processed' => true,
            ],
            default => [
                'event' => $event,
                'data' => $data,
                'processed' => false,
            ],
        };
    }

    private function client(): PendingRequest
    {
        // Monnify uses Basic Auth with API key:secret
        $token = base64_encode("{$this->apiKey}:{$this->secretKey}");

        return Http::withToken($token)
            ->acceptJson()
            ->timeout(30)
            ->baseUrl(self::BASE_URL);
    }
}
```

### 6.9 Service Provider Registration

```php
<?php
// app/Providers/PaymentServiceProvider.php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\PaymentGatewayInterface;
use App\Services\Payment\{MonnifyGateway, NombaGateway, PaystackGateway, PaymentService};
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register individual gateways
        $this->app->singleton(PaystackGateway::class);
        $this->app->singleton(NombaGateway::class);
        $this->app->singleton(MonnifyGateway::class);

        // Register named gateway bindings for direct access
        $this->app->bind('payment.paystack', PaystackGateway::class);
        $this->app->bind('payment.nomba', NombaGateway::class);
        $this->app->bind('payment.monnify', MonnifyGateway::class);

        // Register the orchestrator
        $this->app->singleton(PaymentService::class, function ($app) {
            return new PaymentService(
                $app->make(PaystackGateway::class),
                $app->make(NombaGateway::class),
                $app->make(MonnifyGateway::class),
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
```

---

## 7. Revised Database Schema

### 7.1 Payment Transactions Table

```php
<?php
// database/migrations/2026_08_18_000001_create_payment_transactions_table.php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // User relationship
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('user_email', 255)->index();

            // Transaction identification
            $table->string('reference', 100)->unique()->index();
            $table->string('provider', 20)->index(); // paystack|nomba|monnify
            $table->string('provider_transaction_id', 100)->nullable()->index();

            // Payment details
            $table->string('type', 30)->index(); // subscription|listing|ad|event|one_time
            $table->unsignedBigInteger('amount'); // in kobo (smallest unit)
            $table->string('currency', 3)->default('NGN');
            $table->string('description', 500)->nullable();

            // Provider-specific plan tracking
            $table->string('provider_plan_code', 100)->nullable();
            $table->string('provider_customer_code', 100)->nullable();

            // Subscription reference
            $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();

            // Status tracking
            $table->string('status', 20)->default('pending')->index(); // pending|processing|success|failed|refunded|cancelled
            $table->string('gateway_response', 500)->nullable();
            $table->string('failure_reason', 500)->nullable();

            // Payment method details
            $table->string('channel', 30)->nullable(); // card|bank|ussd|bank_transfer|wallet
            $table->string('card_last4', 4)->nullable();
            $table->string('card_type', 20)->nullable(); // visa|mastercard|verve
            $table->string('bank_name', 100)->nullable();

            // Split payment support
            $table->boolean('is_split')->default(false);
            $table->json('split_details')->nullable(); // [{subaccount_code, share, amount}]

            // International payment flag
            $table->boolean('is_international')->default(false);

            // Metadata and raw response
            $table->json('metadata')->nullable();
            $table->json('provider_response')->nullable(); // raw API response

            // Reconciliation
            $table->timestamp('paid_at')->nullable()->index();
            $table->timestamp('settled_at')->nullable();
            $table->boolean('is_reconciled')->default(false);

            // Soft deletes for audit trail
            $table->timestamps();
            $table->softDeletes();

            // Indexes for common queries
            $table->index(['user_id', 'status']);
            $table->index(['provider', 'status']);
            $table->index(['type', 'status']);
            $table->index(['paid_at', 'provider']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
```

### 7.2 Subscriptions Table

```php
<?php
// database/migrations/2026_08_18_000002_create_subscriptions_table.php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // User relationship
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Subscription plan
            $table->string('plan_name', 100); // "Premium Monthly", "Institution Annual"
            $table->string('plan_tier', 30)->index(); // free|premium|institution
            $table->unsignedBigInteger('amount'); // in kobo per billing cycle
            $table->string('currency', 3)->default('NGN');
            $table->string('billing_interval', 20); // monthly|annually
            $table->unsignedInteger('billing_interval_count')->default(1);

            // Provider details (supports ALL three providers)
            $table->string('provider', 20)->index(); // paystack|nomba|monnify
            $table->string('provider_subscription_code', 100)->nullable()->index();
            $table->string('provider_plan_code', 100)->nullable();
            $table->string('provider_customer_code', 100)->nullable();
            $table->string('provider_token', 500)->nullable(); // authorization/refresh token

            // Status
            $table->string('status', 20)->default('trialing')->index();
            // trial|active|past_due|paused|cancelled|expired|non_renewing

            // Access control
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable()->index();
            $table->timestamp('ends_at')->nullable(); // when access actually ends
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('cancel_at_period_end')->nullable();

            // Payment method on file
            $table->boolean('has_payment_method')->default(false);
            $table->string('payment_method_last4', 4)->nullable();
            $table->string('payment_method_type', 20)->nullable();

            // Dunning & retry
            $table->unsignedInteger('failed_payment_count')->default(0);
            $table->timestamp('last_payment_failure_at')->nullable();
            $table->timestamp('next_retry_at')->nullable();

            // Cancellation tracking
            $table->string('cancellation_reason', 500)->nullable();
            $table->boolean('cancelled_by_user')->default(false);

            // Coupon/discount
            $table->string('coupon_code', 50)->nullable();
            $table->unsignedInteger('discount_percent')->nullable();

            // Metadata
            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for subscription queries
            $table->index(['status', 'current_period_end']);
            $table->index(['provider', 'provider_subscription_code']);
            $table->index(['user_id', 'status']);
            $table->index(['plan_tier', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
```

### 7.3 Payment Plans Table

```php
<?php
// database/migrations/2026_08_18_000003_create_payment_plans_table.php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Plan identification
            $table->string('slug', 50)->unique(); // 'premium-monthly', 'premium-annual', 'institution-annual'
            $table->string('name', 100);
            $table->text('description')->nullable();

            // Pricing
            $table->unsignedBigInteger('amount'); // in kobo
            $table->string('currency', 3)->default('NGN');
            $table->string('billing_interval', 20); // monthly|annually

            // Provider plan codes (one plan may exist on multiple providers)
            $table->string('paystack_plan_code', 100)->nullable()->unique();
            $table->string('monnify_plan_code', 100)->nullable()->unique();
            $table->string('nomba_plan_code', 100)->nullable(); // local-only plan

            // Features & limits
            $table->unsignedInteger('article_limit')->nullable(); // null = unlimited
            $table->boolean('ad_free')->default(false);
            $table->boolean('premium_content')->default(false);
            $table->boolean('community_badge')->default(false);
            $table->json('features')->nullable(); // flexible feature flags

            // Subscription limits
            $table->unsignedInteger('max_seats')->default(1);
            $table->unsignedInteger('trial_days')->default(0);

            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false); // "Most Popular"
            $table->unsignedInteger('display_order')->default(0);

            // Stats
            $table->unsignedInteger('subscriber_count')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_plans');
    }
};
```

### 7.4 Payment Webhook Log Table

```php
<?php
// database/migrations/2026_08_18_000004_create_payment_webhook_logs_table.php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_webhook_logs', function (Blueprint $table) {
            $table->id();

            // Webhook identification
            $table->string('provider', 20)->index();
            $table->string('event_type', 50)->index();
            $table->string('reference', 100)->nullable()->index();

            // Payload
            $table->json('payload');
            $table->string('signature', 255)->nullable();
            $table->boolean('signature_valid')->default(false);

            // Processing
            $table->boolean('processed')->default(false);
            $table->text('processing_error')->nullable();
            $table->unsignedInteger('processing_attempts')->default(0);
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

            $table->index(['provider', 'processed']);
            $table->index(['event_type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_webhook_logs');
    }
};
```

### 7.5 Payment Provider Configuration Table

```php
<?php
// database/migrations/2026_08_18_000005_create_payment_provider_configs_table.php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_provider_configs', function (Blueprint $table) {
            $table->id();

            // Provider identification
            $table->string('provider', 20)->unique();
            $table->string('display_name', 50);
            $table->boolean('is_enabled')->default(false);

            // Configuration (encrypted in production)
            $table->text('api_key')->nullable();
            $table->text('secret_key')->nullable();
            $table->text('webhook_secret')->nullable();
            $table->string('merchant_id', 100)->nullable();
            $table->string('contract_code', 100)->nullable();

            // Feature flags per provider
            $table->boolean('supports_subscriptions')->default(false);
            $table->boolean('supports_splits')->default(false);
            $table->boolean('supports_international')->default(false);
            $table->boolean('supports_ussd')->default(false);

            // Fee structure (for cost optimization routing)
            $table->decimal('fee_percent', 5, 2)->default(1.5);
            $table->decimal('fee_cap', 12, 2)->default(2000.00);
            $table->decimal('fixed_fee', 8, 2)->default(100.00);

            // Priority & fallback
            $table->unsignedInteger('priority')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_fallback')->default(true);

            // Circuit breaker state
            $table->unsignedInteger('consecutive_failures')->default(0);
            $table->timestamp('circuit_opened_at')->nullable();
            $table->boolean('circuit_is_open')->default(false);

            // Stats
            $table->unsignedInteger('total_transactions')->default(0);
            $table->unsignedInteger('successful_transactions')->default(0);
            $table->unsignedInteger('failed_transactions')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_provider_configs');
    }
};
```

---

## 8. Updated Routes

```php
<?php
// routes/web.php (additions)

use App\Http\Controllers\{
    Subscription\SubscriptionController,
    Webhooks\PaystackWebhookController,
    Webhooks\NombaWebhookController,
    Webhooks\MonnifyWebhookController,
};

// ─── Subscription & Payment Routes ────────────────────────────────

Route::middleware('auth')->prefix('subscribe')->name('subscribe.')->group(function () {
    Route::get('/', [SubscriptionController::class, 'index'])->name('index');
    Route::post('/checkout', [SubscriptionController::class, 'checkout'])->name('checkout');
    Route::get('/callback', [SubscriptionController::class, 'callback'])->name('callback');
    Route::get('/success', [SubscriptionController::class, 'success'])->name('success');
    Route::get('/manage', [SubscriptionController::class, 'manage'])->name('manage');
    Route::post('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
    Route::post('/reactivate', [SubscriptionController::class, 'reactivate'])->name('reactivate');
    Route::get('/change-plan', [SubscriptionController::class, 'changePlan'])->name('change-plan');
});

// ─── Webhook Endpoints (No CSRF, No Auth) ─────────────────────────

Route::prefix('webhooks')->name('webhooks.')->withoutMiddleware([
    \App\Http\Middleware\VerifyCsrfToken::class,
])->group(function () {
    Route::post('/paystack', PaystackWebhookController::class)
        ->name('paystack')
        ->middleware('paystack.signature');

    Route::post('/nomba', NombaWebhookController::class)
        ->name('nomba')
        ->middleware('nomba.signature');

    Route::post('/monnify', MonnifyWebhookController::class)
        ->name('monnify')
        ->middleware('monnify.signature');
});
```

### Webhook Signature Middleware

```php
<?php
// app/Http/Middleware/VerifyPaystackSignature.php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyPaystackSignature
{
    public function handle(Request $request, Closure $next): Response
    {
        $signature = $request->header('x-paystack-signature');

        if ($signature === null) {
            return response()->json(['error' => 'Missing signature'], 400);
        }

        $rawBody    = $request->getContent();
        $secret     = config('paystack.webhook_secret');
        $expected   = hash_hmac('sha512', $rawBody, $secret);

        if (! hash_equals($expected, $signature)) {
            abort(403, 'Invalid webhook signature');
        }

        return $next($request);
    }
}
```

---

## 9. Configuration Files

### 9.1 Paystack Configuration

```php
<?php
// config/paystack.php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Paystack Configuration
    |--------------------------------------------------------------------------
    |
    | Paystack payment gateway settings for BLOSSOM Magazine.
    | Paystack is the PRIMARY provider for subscriptions due to
    | its superior recurring billing, dunning, and analytics.
    |
    | Get your keys from: https://dashboard.paystack.co/settings/developer
    |
    */

    // API Keys
    'secret_key'    => env('PAYSTACK_SECRET_KEY'),
    'public_key'    => env('PAYSTACK_PUBLIC_KEY'),
    'webhook_secret' => env('PAYSTACK_WEBHOOK_SECRET'),

    // Merchant details
    'merchant_email' => env('PAYSTACK_MERCHANT_EMAIL', 'billing@blossom.ng'),
    'business_name'  => env('PAYSTACK_BUSINESS_NAME', 'Emerald Colours Nigeria Limited'),

    // Currency
    'currency' => env('PAYSTACK_CURRENCY', 'NGN'),

    // Webhook configuration
    'webhook_url' => env('PAYSTACK_WEBHOOK_URL', env('APP_URL') . '/webhooks/paystack'),

    // Subscription settings
    'subscriptions' => [
        // Default plan codes (created via Paystack dashboard or API)
        'plans' => [
            'premium_monthly'  => env('PAYSTACK_PLAN_PREMIUM_MONTHLY'),
            'premium_annual'   => env('PAYSTACK_PLAN_PREMIUM_ANNUAL'),
            'institution_annual' => env('PAYSTACK_PLAN_INSTITUTION'),
        ],

        // Trial period in days (0 = no trial)
        'trial_days' => 14,

        // Enable automatic retry on failed payments
        'auto_retry' => true,

        // Maximum retry attempts before cancellation
        'max_retries' => 3,
    ],

    // Transaction metadata sent with every payment
    'metadata' => [
        'app_name'    => 'BLOSSOM Magazine',
        'app_version' => '1.0',
    ],

    // Allowed payment channels
    'channels' => ['card', 'bank', 'ussd', 'bank_transfer', 'wallet', 'qr'],

    // Connection timeout in seconds
    'timeout' => 30,

    // Logging
    'log_channel' => 'payments',

    // Split payment default config
    'split_defaults' => [
        'blossom_share_percent' => 15, // BLOSSOM takes 15% of vendor listing fees
        'bearing_type' => 'subaccount', // Who bears transaction fee
    ],

];
```

### 9.2 Nomba Configuration

```php
<?php
// config/nomba.php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Nomba (OPay) Configuration
    |--------------------------------------------------------------------------
    |
    | Nomba is used for ONE-TIME payments (ads, events, general collections)
    | due to its lowest transaction fees in Nigeria.
    |
    | Nomba does NOT support native subscription billing — use Paystack/Monnify.
    |
    */

    'api_key'        => env('NOMBA_API_KEY'),
    'merchant_id'    => env('NOMBA_MERCHANT_ID'),
    'webhook_secret' => env('NOMBA_WEBHOOK_SECRET'),

    'webhook_url' => env('NOMBA_WEBHOOK_URL', env('APP_URL') . '/webhooks/nomba'),

    'currency' => 'NGN',

    'channels' => ['card', 'bank_transfer', 'ussd', 'bank'],

    'timeout' => 30,

    'log_channel' => 'payments',

];
```

### 9.3 Monnify Configuration

```php
<?php
// config/monnify.php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Monnify (Moniepoint) Configuration
    |--------------------------------------------------------------------------
    |
    | Monnify handles SPLIT PAYMENTS for marketplace listings and
    | serves as a fallback for subscriptions when Paystack is unavailable.
    |
    */

    'api_key'        => env('MONNIFY_API_KEY'),
    'secret_key'     => env('MONNIFY_SECRET_KEY'),
    'contract_code'  => env('MONNIFY_CONTRACT_CODE'),
    'webhook_secret' => env('MONNIFY_WEBHOOK_SECRET'),

    'webhook_url' => env('MONNIFY_WEBHOOK_URL', env('APP_URL') . '/webhooks/monnify'),

    'currency' => 'NGN',

    'channels' => ['card', 'bank_transfer', 'bank', 'ussd'],

    'timeout' => 30,

    'log_channel' => 'payments',

    // Split payment defaults
    'split_defaults' => [
        'blossom_share_percent' => 15,
        'default_currency' => 'NGN',
    ],

];
```

### 9.4 Unified Payment Configuration

```php
<?php
// config/payment.php

declare(strict_types=1);

use App\Enums\Payment\{PaymentProvider, TransactionType};

return [

    /*
    |--------------------------------------------------------------------------
    | Unified Payment Configuration
    |--------------------------------------------------------------------------
    |
    | Master configuration for all payment providers. Controls routing,
    | fallback chains, circuit breaker behavior, and provider features.
    |
    */

    // Default provider (when type-based routing doesn't apply)
    'default_provider' => PaymentProvider::PAYSTACK,

    // Provider priority chains per transaction type
    'routing' => [
        TransactionType::SUBSCRIPTION->value => [
            PaymentProvider::PAYSTACK->value,
            PaymentProvider::MONNIFY->value,
            PaymentProvider::NOMBA->value,
        ],

        TransactionType::RECURRING_SPLIT->value => [
            PaymentProvider::MONNIFY->value,
            PaymentProvider::PAYSTACK->value,
            PaymentProvider::NOMBA->value,
        ],

        TransactionType::ONE_TIME->value => [
            PaymentProvider::NOMBA->value,
            PaymentProvider::PAYSTACK->value,
            PaymentProvider::MONNIFY->value,
        ],

        TransactionType::INTERNATIONAL->value => [
            PaymentProvider::PAYSTACK->value,
            PaymentProvider::MONNIFY->value,
            PaymentProvider::NOMBA->value,
        ],
    ],

    // Circuit breaker settings
    'circuit_breaker' => [
        'failure_threshold' => 5,   // failures before opening circuit
        'recovery_timeout' => 60,   // seconds before retrying
        'half_open_max' => 2,       // test requests in half-open state
    ],

    // Reference generation
    'reference_prefix' => 'BLSM',

    // Webhook settings
    'webhook_timeout' => 30,

    // Dunning configuration
    'dunning' => [
        'max_retries' => 3,
        'retry_interval_days' => [3, 7, 14],
        'grace_period_days' => 7,
    ],

];
```

---

## 10. Revised Phase Plan

### Phase 1: Foundation (Weeks 1-3) — UPDATED

```
┌─────────────────────────────────────────────────────────────────┐
│  PHASE 1: TRIPLE PROVIDER FOUNDATION                            │
│                                                                   │
│  ✅ Database migrations (all 5 payment tables)                    │
│  ✅ Enums, DTOs, Value Objects, Exceptions                        │
│  ✅ PaymentGatewayInterface contract                              │
│  ✅ PaystackGateway implementation (PRIMARY)                      │
│  ✅ config/paystack.php + .env setup                              │
│  ✅ Paystack merchant onboarding (dashboard.paystack.co)          │
│  ✅ Create plans on Paystack (premium_monthly, premium_annual)    │
│  ✅ /webhooks/paystack endpoint with HMAC SHA512 verification     │
│  ✅ Paystack signature middleware                                  │
│  ✅ Basic checkout page (Paystack inline JS)                      │
│                                                                   │
│  Deliverables:                                                    │
│  - Working Paystack payments (card, bank transfer)                │
│  - Subscription creation via Paystack API                         │
│  - Webhook processing pipeline                                    │
│  - Database fully seeded with plan records                        │
│                                                                   │
│  Estimated: 15-20 files                                           │
└─────────────────────────────────────────────────────────────────┘
```

### Phase 2: Triple Provider Integration (Weeks 4-6) — NEW

```
┌─────────────────────────────────────────────────────────────────┐
│  PHASE 2: NOMBA + MONNIFY INTEGRATION                            │
│                                                                   │
│  ✅ NombaGateway implementation                                   │
│  ✅ MonnifyGateway implementation                                 │
│  ✅ config/nomba.php + config/monnify.php                         │
│  ✅ Nomba merchant onboarding                                     │
│  ✅ Monnify merchant onboarding                                   │
│  ✅ /webhooks/nomba + /webhooks/monnify endpoints                 │
│  ✅ PaymentService orchestrator with routing table                │
│  ✅ Circuit breaker logic                                         │
│  ✅ Webhook logging table                                         │
│  ✅ Provider config seeding                                       │
│                                                                   │
│  Deliverables:                                                    │
│  - All three providers accepting live payments                    │
│  - Smart routing (subscriptions → Paystack first)                 │
│  - Fallback chains operational                                    │
│  - Unified webhook processing                                     │
│                                                                   │
│  Estimated: 12-15 files                                           │
└─────────────────────────────────────────────────────────────────┘
```

### Phase 3: Subscription Engine (Weeks 7-9) — UPDATED

```
┌─────────────────────────────────────────────────────────────────┐
│  PHASE 3: SUBSCRIPTION LIFECYCLE                                  │
│                                                                   │
│  ✅ Subscription model + CRUD                                     │
│  ✅ Paystack subscription management (create/cancel/reactivate)   │
│  ✅ Monnify subscription management (create/cancel/reactivate)    │
│  ✅ Nomba manual renewal pattern                                  │
│  ✅ Plan upgrade/downgrade flow (provider-agnostic)               │
│  ✅ Trial period management                                       │
│  ✅ Dunning sequence (invoice.payment_failed handling)            │
│  ✅ Subscription dashboard (/subscribe/manage)                    │
│  ✅ Email notifications (renewal reminders, payment failures)     │
│  ✅ Billing history page                                          │
│                                                                   │
│  Deliverables:                                                    │
│  - Full subscription lifecycle on all 3 providers                 │
│  - Auto-renewal working (Paystack primary)                        │
│  - Cancellation + grace period handling                            │
│  - Admin subscription management panel                            │
│                                                                   │
│  Estimated: 15-18 files                                           │
└─────────────────────────────────────────────────────────────────┘
```

### Phase 4: Split Payments & Listings (Weeks 10-12) — UPDATED

```
┌─────────────────────────────────────────────────────────────────┐
│  PHASE 4: MARKETPLACE SPLITS & LISTINGS                          │
│                                                                   │
│  ✅ Monnify split/sub-account creation for vendors                │
│  ✅ Paystack sub-account + split group for vendors                │
│  ✅ Listing submission payment flow (Monnify primary)             │
│  ✅ Vendor payout configuration                                   │
│  ✅ Split verification in webhooks                                │
│  ✅ Vendor billing dashboard                                      │
│  ✅ BLOSSOM commission tracking                                   │
│  ✅ Vendor payout reporting                                       │
│                                                                   │
│  Deliverables:                                                    │
│  - Listing payments split between BLOSSOM and vendors             │
│  - Automated vendor payouts via Monnify sub-accounts              │
│  - Revenue split dashboard for admin                              │
│                                                                   │
│  Estimated: 12-15 files                                           │
└─────────────────────────────────────────────────────────────────┘
```

### Phase 5: Optimization & Analytics (Weeks 13-16) — NEW

```
┌─────────────────────────────────────────────────────────────────┐
│  PHASE 5: ANALYTICS, COST OPTIMIZATION & RELIABILITY             │
│                                                                   │
│  ✅ Payment analytics dashboard (by provider, type, period)       │
│  ✅ Cost optimization: route to cheapest provider per type        │
│  ✅ Reconciliation: match local records with provider dashboards  │
│  ✅ Provider health monitoring + alerting                         │
│  ✅ Refund handling across providers                              │
│  ✅ International card support (Paystack USD)                     │
│  ✅ Export: CSV/PDF financial reports                              │
│  ✅ Load testing: verify fallback under provider outage           │
│  ✅ Security audit: webhook signatures, API key rotation          │
│                                                                   │
│  Deliverables:                                                    │
│  - Real-time payment dashboard in admin                           │
│  - Automated provider failover under outage                       │
│  - Monthly reconciliation reports                                 │
│  - Production-grade reliability                                   │
│                                                                   │
│  Estimated: 10-12 files                                           │
└─────────────────────────────────────────────────────────────────┘
```

### Cost Impact Summary

| Phase | Original (Nomba + Monnify) | Updated (Nomba + Monnify + Paystack) | Delta |
|-------|---------------------------|--------------------------------------|-------|
| Phase 1 | 10-12 files | 15-20 files | +8 files |
| Phase 2 | N/A | 12-15 files | New |
| Phase 3 | 10-12 files | 15-18 files | +6 files |
| Phase 4 | 8-10 files | 12-15 files | +5 files |
| Phase 5 | N/A | 10-12 files | New |
| **Total** | **28-34 files** | **64-80 files** | **+36-46 files** |

### Paystack Merchant Onboarding Steps

```
1. CREATE ACCOUNT
   → https://dashboard.paystack.co/signup
   → Business name: "Emerald Colours Nigeria Limited"
   → Category: "Media & Publishing"

2. COMPLETE KYC
   → Upload CAC certificate
   → Upload utility bill (proof of address)
   → Provide bank account details
   → TAT: 1-3 business days

3. GET API KEYS
   → Dashboard → Settings → API Keys & Webhooks
   → Copy Secret Key, Public Key
   → Set Webhook URL: https://blossom.ng/webhooks/paystack

4. CREATE PLANS
   → Dashboard → Subscriptions → Plans → Create
   → Plan 1: "BLOSSOM Premium Monthly" — ₦2,500/month
   → Plan 2: "BLOSSOM Premium Annual" — ₦20,000/year
   → Plan 3: "BLOSSOM Institution" — ₦100,000/year

5. CONFIGURE WEBHOOKS
   → Settings → API Keys & Webhooks → Webhooks
   → Add: https://blossom.ng/webhooks/paystack
   → Events: charge.success, charge.failed, invoice.created,
     invoice.payment_failed, subscription.create,
     subscription.disable, subscription.not_renewing,
     subscription.expired

6. TEST
   → Use test secret key in sandbox
   → Make test transaction via checkout
   → Verify webhook received at /webhooks/paystack
   → Switch to live keys when ready
```

---

**Architecture Version:** 1.0  
**Last Updated:** August 18, 2026  
**Author:** Fullstack Architecture Team  
**Status:** Ready for Phase 1 Implementation
