<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 14:39
 * description:
 */

namespace LaravelSms\Tests;


use LaravelSms\SmsServiceProvider;

abstract class TestCase extends \Illuminate\Foundation\Testing\TestCase
{

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $this->app = require __DIR__ . '/../src/bootstrap/app.php';
        $this->app->register(SmsServiceProvider::class);
        return $this->app;
    }
}