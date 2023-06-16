<?php

namespace Karim007\LaravelTap;

use Karim007\LaravelTap\Payment\TapPayment;
use Illuminate\Support\ServiceProvider;

class LaravelTapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . "/../config/tap.php" => config_path("tap.php")
        ],'config');
        $this->publishes([
            __DIR__.'/Controllers/TapPaymentController.php' => app_path('Http/Controllers/TapPaymentController.php'),
        ],'controllers');

        $this->loadViewsFrom(__DIR__ . '/Views', 'tapView');
    }

    /**
     * Register application services
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/../config/tap.php", "tap");

        $this->app->bind("tappayment", function () {
            return new TapPayment();
        });
    }
}
