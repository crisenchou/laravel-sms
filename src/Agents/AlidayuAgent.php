<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 11:54
 * description:
 */


namespace LaravelSms\Agents;

class AlidayuAgent extends Agent implements AgentInterface
{

    public function send()
    {
        return $this->message;
    }
}