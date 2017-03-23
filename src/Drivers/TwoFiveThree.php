<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 11:55
 * description:
 */


namespace Crisen\LaravelSms\Drivers;

class TwoFiveThree extends Driver implements DriverInterface
{
    private $url;
    private $un;
    private $pw;
    private $rd;
    private $response;

    public function __construct($config)
    {
        $this->url = $config['url'];
        $this->un = $config['un'];
        $this->pw = $config['pw'];
        $this->rd = $config['rd'];
    }

    public function send()
    {
        $postArr = array(
            'un' => $this->un,
            'pw' => $this->pw,
            'msg' => $this->message,
            'phone' => $this->phone,
            'rd' => $this->rd
        );
        $this->response = $this->curl($this->url, $postArr);
        return $this;
    }

    public function success()
    {
        if (empty($this->response)) {
            return false;
        }

        if (strpos($this->response, ',0')) {
            return true;
        }

        return false;
    }
}