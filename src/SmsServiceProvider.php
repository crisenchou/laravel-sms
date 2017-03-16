<?php

namespace LaravelSms;

/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 10:30
 * description:
 */
use Illuminate\Support\ServiceProvider;
use LaravelSms\Agents\AgentFactory;

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
            return new AgentFactory($app);
        });

        $this->app->singleton('sms', function ($app) {
            return new SmsManager($app, $app['sms.factory']);
        });

    }

//    private function publish()
//    {
//        $path = $this->app->make('path.config') . ('sms.php');
//        $this->publishes([
//            __DIR__ . '/config/sms.php' => $path
//        ], 'config');
//    }
}