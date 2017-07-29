<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 12:05
 * description:
 */


namespace Crisen\LaravelSms\Drivers;


abstract class Driver
{
    protected $phone;
    protected $message;

    public function to($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function message($message = null)
    {
        $message && $this->message = $message;
        return $this;
    }

    protected static function curl($url, array $params = [], $isPost = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($isPost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            $params = http_build_query($params);
            curl_setopt($ch, CURLOPT_URL, $params ? "$url?$params" : $url);
        }
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    protected function curlPost($url, array $params = [])
    {
        return $this->curl($url, $params, true);
    }

    abstract public function send();
}