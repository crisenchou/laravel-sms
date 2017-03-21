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


    public function __construct($config)
    {
        $this->url = $config['url'];
        $this->appKey = $config['app_key'];
        $this->secretKey = $config['secret_key'];
        $this->smsFreeSignName = $config['sms_free_sign_name'];
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
        $this->response = $this->curl($this->url, $params, true);
        return $this;
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
     * 按照模版构造json
     * @param $template
     */
    public function template($template)
    {
        $this->message = $template;
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
    protected function getSign($params)
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
     * 返回结果
     * @return mixed
     */
    protected function getResponse()
    {
        return $this->response;
    }

    public function success()
    {

    }

}