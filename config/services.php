<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    //排行榜
    'ranking' => [
        'redis' => 'default',
    ],
    'weibo' => [
        'client_id' => env('WEIBO_ID', ''),
        'client_secret' => env('WEIBO_SECRET', ''),
        'redirect' => env('WEIBO_REDIRECT', '')
    ],

    'qq' => [
        'client_id' => env('QQ_KEY', ''),
        'client_secret' => env('QQ_SECRET', ''),
        'redirect' => env('QQ_REDIRECT_URI', '')
    ],

    'weixinweb' => [//对应微信开放平台 网站
        'client_id' => env('WEIXIN_ID', ''),
        'client_secret' => env('WEIXIN_SECRET', ''),
        'redirect' => env('WEIXIN_REDIRECT', '')
    ],

    'weixin-mobile' => [//对应微信开放平台 移动应用
        'client_id' => env('WEIXIN_ID', ''),
        'client_secret' => env('WEIXIN_SECRET', ''),
        'redirect' => env('WEIXIN_REDIRECT', '')
    ],

    'weixin' => [//微信公众平台
        //'client_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID', ''),
        //'client_secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET', ''),
        //'redirect' => env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_CALLBACK', ''),

        //以下为测试号
        'client_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID', ''),
        'client_secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET', ''),
        'redirect' => env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_CALLBACK', '')
    ],

    'weixinminiprogram' => [//微信小程序
        'client_id' => env('WECHAT_MINI_PROGRAM_APPID', ''),
        'client_secret' => env('WECHAT_MINI_PROGRAM_SECRET', ''),
        'redirect' => env('WEIXIN_REDIRECT', '')
    ],
];
