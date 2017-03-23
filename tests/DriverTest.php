<?php

/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 11:30
 * description:
 */

namespace Crisen\LaravelSms\Tests;

use Crisen\LaravelSms\Facades\Sms;


class DriverTest extends \Tests\TestCase
{
    private $phone = '13713577687';

    public function setPhone($phone = null)
    {
        $this->phone = $phone;
        return $this->phone;
    }
    
    public function testAlidayu()
    {
        $templateMessage = [
            'code' => '123456',
            'time' => 10
        ];
        $response = Sms::make()->to($this->phone)->message($templateMessage)->send();
        $this->assertTrue($response->success());
    }

    public function testTwoFiveThree()
    {
        $message = mt_rand(1000, 9999);
        $response = Sms::make('253')->to($this->phone)->message($message)->send();
        $this->assertTrue($response->success());
    }

}