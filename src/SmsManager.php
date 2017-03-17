<?php

/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 10:27
 * description:
 */

namespace LaravelSms;

use LaravelSms\Drivers\DriverFactory;

class SmsManager
{
    protected $app;

    protected $factory;

    protected $config = [];

    public function __construct($app, DriverFactory $factory, $config)
    {
        $this->app = $app;
        $this->factory = $factory;
        $this->config = $config;
    }

    public function getDefaultName()
    {
        return $this->config['default'];
    }

    public function make($driverName = null)
    {
        $driverName = $driverName ?: $this->getDefaultName();
        $config = $this->getDriver($driverName);
        return $this->factory->make($config, $driverName);
    }

    public function getDriver($agent = null)
    {
        return $this->config['drivers'][$agent];
    }

    protected function getConfig()
    {
        return $this->config;
    }

}