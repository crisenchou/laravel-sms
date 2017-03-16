<?php

/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 11:30
 * description:
 */

namespace LaravelSms\Tests;

use LaravelSms\Facades\Sms;

class AgentTest extends TestCase
{
    public $mobile = '13713577687';
    public $message = 'test message';

    public function testAlidayu()
    {
        $this->createApplication();
        $sms = $this->app->make('sms');
        $message = $sms->make()->to($this->mobile)->send($this->message);
        $this->assertEquals($message, $this->message);
    }


}