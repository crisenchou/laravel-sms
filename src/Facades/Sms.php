<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 10:54
 * description:
 */

namespace Crisen\LaravelSms\Facades;

use Illuminate\Support\Facades\Facade;

class Sms extends Facade
{
    public static function getFacadeAccessor()
    {
        return "sms";
    }
}