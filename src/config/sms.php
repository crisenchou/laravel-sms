<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 10:30
 * description:
 */

return [
    'default' => 'alidayu',

    'drivers' => [
        'alidayu' => [
            'url' => 'https://gw.api.tbsandbox.com/router/rest',//沙箱环境
            //'url' => 'https://eco.taobao.com/router/rest',//正式环境
            'app_key' => 'your appkey',//应用id
            'secret_key' => 'your secretkey',//应用密钥
            'sms_free_sign_name' => 'your signname',//消息签名 在阿里大于后台中心配置
            'sms_template' => '',//模版变量  示例 name,code  以逗号形式分隔
            'sms_template_code' => 'your template code id', //短信模板ID
        ],


        'ronglian' => [
            'url' => '',
            'appkey' => 'your secretkey',
            'secretkey' => 'your secretkey',
        ],


        '253' => [
            'url' => 'http://sms.253.com/msg/send',
            'un' => 'your username',//用户账号
            'pw' => 'your password', //用户密码
            'rd' => '0',//是否需要状态报告
            'ex' => ''//可选透传参数
        ],

    ],
];