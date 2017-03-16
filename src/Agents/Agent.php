<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 12:05
 * description:
 */


namespace LaravelSms\Agents;


abstract class Agent
{
    protected $mobile;
    protected $message;

    public function to($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    abstract public function send();
}