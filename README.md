# laravel-sms
安装配置简单的laravel手机短信集成库

## 安装

~~~
composer require "crisen/laravel-sms":"dev-master"
~~~

## 配置

在config的app.php文件中添加

~~~
'providers' => [
  ...
  Crisen\LaravelSms\SmsServiceProvider::class
];
~~~

~~~
'aliases' => [
...
  'Sms' => Crisen\LaravelSms\Facades\Sms::class
];
~~~

> 然后使用artisan vendor:publish发布配置文件


### 阿里云短信服务

~~~
use Sms;
...

public function foo(){
	$phone = "13800138000";
	$code = "1234";
	$template = "SMS_0000001";
  	$res = Sms::make()->to($phone)
		->message(json_encode(['code' => $code]))
		->template($template)
		->send();
	if($res){
        //do successful
	}
}
~~~

## License

MIT
