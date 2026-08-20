<?php

namespace App\Livewire;

use App\Enums\Payment\PaymentProvider;
use App\Models\Service;
use App\Models\Subscription;
use App\Services\Payment\PaymentService;
use App\ValueObjects\Money;
use App\Enums\Payment\TransactionType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SubscriptionCheckout extends Component
{
    public string $selectedPlan = 'monthly';
    public string $selectedProvider = 'paystack';
    public bool $processing = false;
    public string $error = '';
    public string $success = '';

    public array $plans = [];

    public array $providers = [];

    protected array $planFeatures = [
        'monthly' => [
            'Unlimited premium articles',
            'Monthly newsletter digest',
            'Community access',
            'Event early-bird pricing',
        ],
        'yearly' => [
            'Everything in Monthly',
            '2 months free',
            'Priority featured listing',
            'Exclusive annual gala invite',
            'Direct editorial access',
        ],
    ];

    protected array $defaultProviderDescriptions = [
        'paystack' => ['name' => 'Paystack', 'description' => 'Card, Bank Transfer, USSD', 'icon' => '💳'],
        'monnify' => ['name' => 'Monnify', 'description' => 'Bank Transfer, Card', 'icon' => '🏦'],
        'nomba' => ['name' => 'Nomba', 'description' => 'OPay, Bank Transfer', 'icon' => '📱'],
    ];

    public function mount(): void
    {
        $this->plans = $this->resolvePlans();
        $this->providers = $this->resolveProviders();
        $this->selectedProvider = $this->resolveDefaultProvider();
    }

    public function selectPlan(string $plan): void
    {
        $this->selectedPlan = $plan;
    }

    public function selectProvider(string $provider): void
    {
        $this->selectedProvider = $provider;
    }

    /**
     * Build the plan list from config, overlaid with admin settings.
     */
    protected function resolvePlans(): array
    {
        $defaults = config('blossom.subscriptions.plans', []);

        $plans = [];

        foreach ($defaults as $key => $cfg) {
            $plans[$key] = [
                'name' => (string) setting("payment.payment.plans.{$key}.name", $cfg['name'] ?? ucfirst($key)),
                'price' => (float) setting("payment.payment.plans.{$key}.price", $cfg['price'] ?? 0),
                'currency' => $cfg['currency'] ?? 'NGN',
                'interval' => $cfg['interval'] ?? ($key === 'yearly' ? 'yearly' : 'monthly'),
                'features' => $this->planFeatures[$key] ?? [],
            ];
        }

        return $plans;
    }

    /**
     * Build the provider list from enabled payment services in the
     * Service Manager, falling back to the built-in provider set.
     */
    protected function resolveProviders(): array
    {
        $enabled = Service::enabledFor('payment');

        if ($enabled->isEmpty()) {
            return collect($this->defaultProviderDescriptions)->map(fn ($p, $key) => [
                'name' => $p['name'],
                'description' => $p['description'],
                'icon' => $p['icon'],
            ])->all();
        }

        return $enabled->mapWithKeys(function (Service $service) {
            $default = $this->defaultProviderDescriptions[$service->name] ?? [];

            return [
                $service->name => [
                    'name' => $service->display_name ?: ($default['name'] ?? ucfirst($service->name)),
                    'description' => $default['description'] ?? 'Payment via ' . $service->display_name,
                    'icon' => $default['icon'] ?? '💳',
                ],
            ];
        })->all();
    }

    /**
     * Default to the primary payment service, then the configured default,
     * then the first enabled provider.
     */
    protected function resolveDefaultProvider(): string
    {
        $enabled = Service::enabledFor('payment');
        $names = $enabled->isNotEmpty()
            ? $enabled->pluck('name')->all()
            : array_keys($this->defaultProviderDescriptions);

        $primary = Service::primary('payment');

        if ($primary && in_array($primary->name, $names, true)) {
            return $primary->name;
        }

        $configuredDefault = (string) setting('payment.payment.default_provider', config('blossom.payments.default', 'paystack'));

        if (in_array($configuredDefault, $names, true)) {
            return $configuredDefault;
        }

        return $names[0] ?? 'paystack';
    }

    public function initiatePayment(PaymentService $paymentService): void
    {
        if (!Auth::check()) {
            $this->redirectRoute('login');
            return;
        }

        $this->processing = true;
        $this->error = '';
        $this->success = '';

        try {
            $planData = $this->plans[$this->selectedPlan];
            $amount = Money::fromNaira((float) $planData['price']);

            // Check for existing active subscription
            $existing = Subscription::where('user_id', Auth::id())
                ->where('status', 'active')
                ->first();

            if ($existing) {
                $this->error = 'You already have an active subscription.';
                $this->processing = false;
                return;
            }

            // Create pending subscription record (NOT active yet).
            // Amount stored in kobo (minor units), matching transactions.amount (C6).
            $subscription = Subscription::create([
                'user_id' => Auth::id(),
                'plan' => $this->selectedPlan,
                'status' => 'pending',
                'amount' => $planData['price'] * 100,
                'currency' => $planData['currency'],
                'starts_at' => now(),
                'ends_at' => $this->selectedPlan === 'yearly' ? now()->addYear() : now()->addMonth(),
            ]);

            $reference = 'BLS-' . strtoupper(uniqid()) . '-' . strtoupper(bin2hex(random_bytes(3)));

            $providerEnum = PaymentProvider::from($this->selectedProvider);

            $result = $paymentService->initializePayment(
                email: Auth::user()->email,
                amount: $amount,
                reference: $reference,
                description: "BLOSSOM Subscription — {$planData['name']}",
                type: TransactionType::SUBSCRIPTION,
                metadata: [
                    'user_id' => Auth::id(),
                    'subscription_id' => $subscription->id,
                    'selected_plan' => $this->selectedPlan,
                    'custom_fields' => [
                        ['display_name' => 'Plan', 'variable_name' => 'plan', 'value' => $this->selectedPlan],
                        ['display_name' => 'Subscription ID', 'variable_name' => 'subscription_id', 'value' => $subscription->id],
                    ],
                ],
                preferredProvider: $providerEnum,
                userId: Auth::id(),
            );

            if (isset($result['authorization_url'])) {
                $this->redirect($result['authorization_url']);
                return;
            }

            $this->error = 'Payment initialization failed. Please try again.';
        } catch (\Exception $e) {
            $this->error = 'An error occurred: ' . $e->getMessage();
            \Log::error('Subscription checkout error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);
        }

        $this->processing = false;
    }

    public function render()
    {
        return view('livewire.subscription-checkout');
    }
}
