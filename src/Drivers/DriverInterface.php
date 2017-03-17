<?php

/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 10:37
 * description:
 */

namespace LaravelSms\Drivers;

interface DriverInterface
{
    public function to($phone);

    public function message($message);

    public function send();
}