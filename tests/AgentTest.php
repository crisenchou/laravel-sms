<?php

/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 11:30
 * description:
 */

namespace LaravelSms\Tests;


class AgentTest extends TestCase
{
    private $mobile = '13713577687';
    private $message = '1234';
    private $sms;


    public function getInstance()
    {
        if (is_object($this->sms)) {
            return $this->sms;
        } else {
            return $this->serInstance();
        }
    }

    public function serInstance()
    {
        $this->createApplication();
        $this->sms = $this->app->make('sms');
        return $this->sms;
    }

    public function testAlidayu()
    {
        $sms = $this->getInstance();
        $message = $sms->make()->to($this->mobile)->message($this->message)->send();
        $this->assertEquals($message, $this->message);
    }

    public function testTwoFiveThree()
    {
        $sms = $this->getInstance();
        $response = $sms->make('253')->to($this->mobile)->message($this->message)->send();
        dump($response);
        $this->assertTrue($response->success());
    }


}