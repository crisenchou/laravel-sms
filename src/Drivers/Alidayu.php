<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 11:54
 * description:
 */

namespace Crisen\LaravelSms\Drivers;

class Alidayu extends Driver implements DriverInterface
{
    private $appKey;
    private $url;
    private $secretKey;
    private $smsmType = 'normal';
    private $smsFreeSignName;
    private $smsTemplateCode;
    private $response;
    private $template;

    public function __construct($config)
    {
        $this->url = $config['url'];
        $this->appKey = $config['app_key'];
        $this->secretKey = $config['secret_key'];
        $this->smsFreeSignName = $config['sms_free_sign_name'];
        $this->template = $config['sms_template'];
    }

    /**
     * 发送信息
     * @return $this
     */
    public function send()
    {
        $params = $this->getParams();
        $sign = $this->getSign($params);
        $params['sign'] = $sign;
        $response = $this->curl($this->url, $params, true);
        $this->response = $this->parseReponse($response);
        if ($this->success()) {
            return $this->getResponse();
        }
    }

    /**
     * @param $parse
     * @return mixed
     */
    private function parseReponse($parse)
    {
        return json_decode(json_encode(simplexml_load_string($parse)), true);
    }

    /**
     * 获取发送参数
     * @return array
     */
    protected function getParams()
    {
        $params = [
            'sms_type' => $this->smsmType,
            'sms_free_sign_name' => $this->smsFreeSignName,
            'rec_num' => $this->phone,
            'sms_template_code' => $this->smsTemplateCode,
            'sms_param' => $this->message,
        ];
        $params = array_merge($this->getPublicParams(), $params);
        return $params;
    }


    /**
     * 获取公共请求参数
     * @return array
     */
    private function getPublicParams()
    {
        $publicParams = [
            'method' => 'alibaba.aliqin.fc.sms.num.send',
            'app_key' => $this->appKey,
            'sign_method' => 'md5',
            'timestamp' => date("Y-m-d H:i:s"),
            'v' => '2.0',
        ];
        return $publicParams;
    }


    /**
     * 生成签名
     * @param $params
     * @return string
     */
    private function getSign($params)
    {
        ksort($params);
        $stringToBeSigned = $this->secretKey;
        foreach ($params as $k => $v) {
            if (is_string($v) && '@' !== substr($v, 0, 1)) {
                $stringToBeSigned .= "$k$v";
            }
        }
        unset($k, $v);
        $stringToBeSigned .= $this->secretKey;
        return strtoupper(md5($stringToBeSigned));
    }


    /**
     * @param null $message
     * @return $this
     */
    public function message($message = null)
    {
        if (!is_array($message)) {
            $message = [$message];
        }
        $template = $this->getTemplate();
        $this->message = json_encode(array_combine($template, $message));
        return $this;
    }

    /**
     * @return array
     */
    private function getTemplate()
    {
        return strpos(',', $this->template) ? $this->template : explode(',', $this->template);
    }

    /**
     * 返回结果
     * @return mixed
     */
    protected function getResponse()
    {
        return $this->response;
    }

    public function success()
    {
        if (isset($this->response['success'])) {
            return $this->response['success'];
        } else {
            throw new \Exception($this->response['msg']);
        }
    }
}