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

    public function getDefaultAgent()
    {
        return $this->config['default'];
    }

    public function make($agent = null)
    {
        $agent = $agent ?: $this->getDefaultAgent();
        $config = $this->getAgent($agent);

        return $this->factory->make($config, $agent);
    }

    public function getAgent($agent = null)
    {
        return $this->config['drivers'][$agent];
    }

    protected function getConfig()
    {
        return $this->config;
    }

}