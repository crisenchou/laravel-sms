<?php

namespace Crisen\LaravelSms\Drivers;

class Aliyun extends Driver implements DriverInterface
{
    protected static $sendUrl = 'https://dysmsapi.aliyuncs.com/';

    protected $tempId = 'SMS_78885339';
    protected $regionId;
    protected $signName;
    protected $accessKeyId;
    protected $accessKeySecret;
    protected $result;


    public function __construct($config)
    {
        $this->accessKeyId = $config['accessKeyId'];
        $this->accessKeySecret = $config['accessKeySecret'];
        $this->signName = $config['signName'];
        $this->regionId = $config['regionId'];
    }

    public function sendTemplateSms($to, $tempId, array $data)
    {
        $params = [
            'Action' => 'SendSms',
            'SignName' => $this->signName,
            'TemplateParam' => $this->getTempDataString($data),
            'PhoneNumbers' => $to,
            'TemplateCode' => $tempId,
        ];
        $this->request($params);
    }

    public function send()
    {
        $to = $this->phone;
        $tempId = $this->tempId;
        $data = ['code' => $this->message];
        return $this->sendTemplateSms($to, $tempId, $data);
    }

    protected function request(array $params)
    {
        $params = $this->createParams($params);
        $result = $this->curlPost(self::$sendUrl, $params);
        $this->result = $result;
        if ($this->success()) {
            return true;
        } else {
            throw new \Exception('发送失败');
        }
    }

    protected function success()
    {
        if ($result = json_decode($this->result, true)) {
            if ('OK' == $result['Message'] && 'OK' == $result['Code']) {
                return $result;
            }
        }
        return false;
    }

    protected function createParams(array $params)
    {
        $params = array_merge([
            'RegionId' => $this->regionId ?: 'cn-shenzhen',
            'Format' => 'JSON',
            'Version' => '2017-05-25',
            'AccessKeyId' => $this->accessKeyId,
            'SignatureMethod' => 'HMAC-SHA1',
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'SignatureVersion' => '1.0',
            'SignatureNonce' => uniqid(),
        ], $params);
        $params['Signature'] = $this->computeSignature($params);
        return $params;
        //return $this->params($params);
    }

    private function computeSignature($parameters)
    {
        ksort($parameters);
        $canonicalizedQueryString = '';
        foreach ($parameters as $key => $value) {
            $canonicalizedQueryString .= '&' . $this->percentEncode($key) . '=' . $this->percentEncode($value);
        }
        $stringToSign = 'POST&%2F&' . $this->percentEncode(substr($canonicalizedQueryString, 1));

        return base64_encode(hash_hmac('sha1', $stringToSign, $this->accessKeySecret . '&', true));
    }

    protected function percentEncode($str)
    {
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }


    protected function getTempDataString(array $data)
    {
        $data = array_map(function ($value) {
            return (string)$value;
        }, $data);

        return json_encode($data);
    }
}
