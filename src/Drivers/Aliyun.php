<?php

namespace Crisen\LaravelSms\Drivers;

use Mockery\CountValidator\Exception;

class Aliyun extends Driver implements DriverInterface
{
    protected $sendUrl;
    protected $tempId;
    protected $regionId;
    protected $signName;
    protected $accessKeyId;
    protected $accessKeySecret;
    protected $result;


    public function __construct($config)
    {
        $this->sendUrl = $config['url'];
        $this->accessKeyId = $config['accessKeyId'];
        $this->accessKeySecret = $config['accessKeySecret'];
        $this->signName = $config['signName'];
        $this->regionId = $config['regionId'];
    }

    public function send()
    {
        $this->checkParams();
        $params = [
            'Action' => 'SendSms',
            'SignName' => $this->signName,
            'TemplateParam' => $this->message,
            'PhoneNumbers' => $this->phone,
            'TemplateCode' => $this->tempId,
        ];

        return $this->request($params);
    }

    protected function checkParams()
    {
        if (!$this->phone) {
            throw new Exception('手机号不存在');
        }
        if (!$this->message) {
            throw new Exception('没有信息');
        }
        if (!$this->tempId) {
            throw new Exception('没有模版id');
        }
    }


    public function setSignName($name)
    {
        $this->signName = $name;
    }


    public function template($template)
    {
        $this->tempId = $template;
        return $this;
    }

    protected function request(array $params)
    {
        $params = $this->createParams($params);
        $result = $this->curlPost($this->sendUrl, $params);
        $this->result = $result;
        if ($this->success()) {
            return true;
        } else {
            $message = json_decode($this->result, true);
            throw new Exception($message['Message']);
        }
    }

    protected function success()
    {
        $result = json_decode($this->result, true);
        if (!is_array($result)) {
            return false;
        }

        if ('OK' == $result['Message'] && 'OK' == $result['Code']) {
            return $result;
        }
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
    }

    private function computeSignature($parameters)
    {
        ksort($parameters);
        $queryString = '';
        foreach ($parameters as $key => $value) {
            $queryString .= '&' . $this->percentEncode($key) . '=' . $this->percentEncode($value);
        }
        $stringToSign = 'POST&%2F&' . $this->percentEncode(substr($queryString, 1));
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

}
