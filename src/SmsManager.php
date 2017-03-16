<?php

/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 10:27
 * description:
 */

namespace LaravelSms;

use LaravelSms\Agents\AgentFactory;

class SmsManager
{
    protected $app;

    protected $factory;

    protected $config = [];

    protected $agent = [];

    public function __construct($app, AgentFactory $factory)
    {
        $this->app = $app;
        $this->factory = $factory;
        $this->config = $this->getConfig();
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


    public function getAgent($name = null)
    {
        return $this->config['agents'][$name];
    }

    protected function getConfig()
    {
        return require_once(__DIR__ . '/config/sms.php');
    }

}