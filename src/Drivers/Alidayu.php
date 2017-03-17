<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 11:54
 * description:
 */


namespace LaravelSms\Drivers;

class Alidayu extends Driver implements DriverInterface
{

    public function send()
    {
        return $this->message;
    }
}