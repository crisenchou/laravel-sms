<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 11:55
 * description:
 */


namespace LaravelSms\Agents;

class TwoFiveThreeAgent extends Agent implements AgentInterface
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
            'phone' => $this->mobile,
            'rd' => $this->rd
        );
        $this->response = $this->curl($this->url, $postArr);
        return $this;
    }


    public static function curl($url, array $params = [], $isPost = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22');
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

        if (strlen($response) && strpos($response, PHP_EOL)) {
            $response = substr($response, 0, strpos($response, PHP_EOL));
        }
        return $response;
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