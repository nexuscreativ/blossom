<?php

namespace App\Providers;

use App\Services\Payment\Gateways\MonnifyGateway;
use App\Services\Payment\Gateways\NombaGateway;
use App\Services\Payment\Gateways\PaystackGateway;
use App\Services\Payment\PaymentService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PaymentService::class, function () {
            $service = new PaymentService();
            $service->registerGateway(new PaystackGateway());
            $service->registerGateway(new MonnifyGateway());
            $service->registerGateway(new NombaGateway());
            return $service;
        });

        $this->app->alias(PaymentService::class, 'payment');
    }

    public function boot(): void
    {
        //
    }
}
