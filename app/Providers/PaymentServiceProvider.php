<?php

namespace App\Providers;

use App\Billing\Gateway1;
use App\Billing\Gateway2;
use App\Billing\PaymentGatewayContract;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PaymentGatewayContract::class, function ($app) {
            if (request()->has('merchant_id')) {
                return new Gateway1();
            } elseif (request()->has('project')) {
                return new Gateway2();
            }

            throw new \RuntimeException("Unknown payment gateway");
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
