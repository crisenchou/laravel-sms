<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 2017/3/16 10:30
 * description:
 */

return [
    'default' => 'alidayu',

    'agents' => [
        'alidayu' => [
            'url' => '',
            'appkey' => 'your secretkey',
            'secretkey' => 'your secretkey',
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
            'ex' => ''
        ],
    ],
];