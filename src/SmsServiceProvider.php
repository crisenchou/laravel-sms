<?php

namespace LaravelSms;

/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 10:30
 * description:
 */
use Illuminate\Support\ServiceProvider;
use LaravelSms\Drivers\DriverFactory;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //$this->publish();
        $this->app->singleton('sms.factory', function ($app) {
            return new DriverFactory($app);
        });

        $this->app->singleton('sms', function ($app) {
            $config = require(__DIR__ . '/config/sms.php');
            return new SmsManager($app, $app['sms.factory'], $config);
        });
    }

    private function publish()
    {
        $path = $this->app->make('path.config') . ('sms.php');
        $this->publishes([
            __DIR__ . '/config/sms.php' => $path
        ], 'config');
    }
}