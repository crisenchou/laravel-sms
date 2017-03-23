<?php

namespace Crisen\LaravelSms;

/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 10:30
 * description:
 */
use Illuminate\Support\ServiceProvider;
use Crisen\LaravelSms\Drivers\DriverFactory;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    public function boot()
    {
        $this->publish();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('sms.factory', function ($app) {
            return new DriverFactory($app);
        });

        $this->app->singleton('sms', function ($app) {
            $this->mergeConfigFrom(__DIR__ . '/config/sms.php', 'sms');
            return new SmsManager($app, $app['sms.factory'], config('sms'));
        });
    }

    private function publish()
    {
        $this->publishes([
            __DIR__ . '/config/sms.php' => config_path('sms'),
        ]);
    }
}