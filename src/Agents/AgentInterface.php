<?php

/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 10:37
 * description:
 */

namespace LaravelSms\Agents;

interface AgentInterface
{
    public function to($phone);

    public function message($message);

    public function send();
}