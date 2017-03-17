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

            $config = $this->mergeConfigFrom(__DIR__ . '/config/sms.php', 'sms');
            return new SmsManager($app, $app['sms.factory'], $config);
        });
    }

    protected function mergeConfigFrom($path, $key)
    {
        $config = $this->app['config']->get($key, []);
        $this->app['config']->set($key, array_merge(require $path, $config));
        dump($this->app['config']);
        return $this->app['config'];
    }

    private function publish()
    {
        $path = $this->app->make('path.config') . (DIRECTORY_SEPARATOR . 'sms.php');
        $this->publishes([
            __DIR__ . '/config/sms.php' => $path
        ], 'config');
    }
}