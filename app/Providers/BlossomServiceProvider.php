<?php

namespace App\Providers;

use App\Observers\SettingObserver;
use App\Models\Setting;
use App\Services\ServiceRegistry;
use App\Services\Payment\Gateways\PaystackService;
use App\Services\Payment\Gateways\MonnifyService;
use App\Services\Payment\Gateways\NombaService;
use App\Services\Email\MailgunService;
use App\Services\Sms\TermiiService;
use App\Services\Storage\CloudinaryService;
use App\Services\Analytics\GoogleAnalyticsService;
use App\Services\OAuth\GoogleOAuthService;
use App\Services\OAuth\FacebookOAuthService;
use App\Services\OAuth\TwitterOAuthService;
use App\Services\Chat\RespondIoService;
use Illuminate\Support\ServiceProvider;

class BlossomServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ServiceRegistry::class, function () {
            $registry = new ServiceRegistry();

            // Only register implementations that exist; Phase 3 adds the rest.
            $candidates = [
                'payment' => [
                    'paystack' => PaystackService::class,
                    'monnify' => MonnifyService::class,
                    'nomba' => NombaService::class,
                ],
                'email' => [
                    'mailgun' => MailgunService::class,
                ],
                'sms' => [
                    'termii' => TermiiService::class,
                ],
                'storage' => [
                    'cloudinary' => CloudinaryService::class,
                ],
                'analytics' => [
                    'google_analytics' => GoogleAnalyticsService::class,
                ],
                'oauth' => [
                    'google' => GoogleOAuthService::class,
                    'facebook' => FacebookOAuthService::class,
                    'twitter' => TwitterOAuthService::class,
                ],
                'chat' => [
                    'respondio' => RespondIoService::class,
                ],
            ];

            foreach ($candidates as $category => $services) {
                foreach ($services as $name => $implementation) {
                    if (class_exists($implementation)) {
                        $registry->register($category, $name, $implementation);
                    }
                }
            }

            return $registry;
        });

        $this->app->alias(ServiceRegistry::class, 'services');
    }

    public function boot(): void
    {
        Setting::observe(SettingObserver::class);
    }
}
