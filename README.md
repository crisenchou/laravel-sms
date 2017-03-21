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



### 支持的驱动

等待更新

### 使用说明

~~~
use Sms;
...

public function foo(){
	$code = '1234';
	$mobile = '135xxxx6548'
  	Sms::make()->to(mobile)->message($code)->send();
}
~~~

## License

MIT