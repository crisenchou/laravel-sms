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
    private $message = '1234';


    public function setPhone($phone = null)
    {
        $this->phone = $phone;
        return $this->phone;
    }

    public function setMessage($message = null)
    {
        if (!$message) {
            $message = mt_rand(1000, 9999);
        }
        $this->message = $message;
        return $message;
    }

    public function testAlidayu()
    {
        $this->setMessage();
        $message = Sms::make()->to($this->phone)->message($this->message)->send();
        $this->assertEquals($message, $this->message);
    }

    public function testTwoFiveThree()
    {
        $this->setMessage();
        $response = Sms::make('253')->to($this->phone)->message($this->message)->send();
        $this->assertTrue($response->success());
    }


}