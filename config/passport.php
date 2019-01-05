<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Encryption Keys
    |--------------------------------------------------------------------------
    |
    | Passport uses encryption keys while generating secure access tokens for
    | your application. By default, the keys are stored as local files but
    | can be set via environment variables when that is more convenient.
    |
    */

    'private_key' => env('PASSPORT_PRIVATE_KEY'),

    'public_key' => env('PASSPORT_PUBLIC_KEY'),

    //设置令牌过期时间15天
    'tokens_expire_in' => env('PASSPORT_TOKENS_EXPIRE_IN', 15),

    //设置刷新令牌过期时间30天
    'refreshTokensExpireIn' => env('PASSPORT_REFRESH_TOKENS_EXPIRE_IN', 30),
];
