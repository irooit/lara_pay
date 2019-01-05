<?php

use Illuminate\Contracts\Routing\Registrar as RouteContract;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * RESTFul API common.
 *
 * Define the version of the interface that conforms to most of the
 * REST ful specification.
 */
Route::group(['prefix' => 'common'], function (RouteContract $api) {
    Route::get('timezone', 'Api\MainController@timezone');//时区列表
    Route::get('dns-record', 'Api\MainController@dnsRecord');
    Route::post('sms-verify-code', 'Api\MainController@PhoneSmsVerifyCode');//短信验证码
    Route::post('mail-verify-code', 'Api\MainController@MailVerifyCode');//邮件验证码
});

/**
 * RESTFul API geographic.
 *
 * Define the version of the interface that conforms to most of the
 * REST ful specification.
 */
Route::group(['prefix' => 'geographic'], function (RouteContract $api) {
    Route::get('country', 'Api\GeographicController@country');//国家列表
    //Route::get('province', 'Api\GeographicController@province');//省列表
    //Route::get('city/{province}', 'Api\GeographicController@city');//市列表
});

/**
 * RESTFul API version 1.
 *
 * Define the version of the interface that conforms to most of the
 * REST ful specification.
 */
Route::group(['prefix' => 'v1'], function (RouteContract $api) {

    /**
     * 交易接口
     */
    Route::group(['prefix' => 'transaction'], function () {
        Route::post('charge', 'Api\V1\Transaction\ChargeController@store');//收款
        Route::post('charge/{id}', 'Api\V1\Transaction\ChargeController@query');//收款查询
        Route::post('notify/{channel}', 'Api\V1\Transaction\NotifyController@charge');//收款通知回调
        Route::post('refund', 'Api\V1\Transaction\RefundController@store');//退款
        //Route::post('transfer', 'Api\V1\Transaction\TransferController@store');//转账
    });

    /**
     * 用户接口
     */
    Route::group(['prefix' => 'user'], function () {
        Route::post('phone-register', 'Api\V1\UserController@phoneRegister');//手机号注册
        Route::post('email-register', 'Api\V1\UserController@emailRegister');//邮箱注册
        Route::post('phone-reset-password', 'Api\V1\UserController@resetPasswordByPhone');//通过手机重置用户登录密码

        Route::get('profile', 'Api\V1\UserController@profile');//获取用户个人资料
        Route::get('extra', 'Api\V1\UserController@extra');//获取扩展资料
        Route::post('profile', 'Api\V1\UserController@modifyProfile');//修改用户个人资料
        Route::post('avatar', 'Api\V1\UserController@modifyAvatar');//修改头像
        Route::post('password', 'Api\V1\UserController@modifyPassword');//修改密码

        Route::get('identification', 'Api\V1\UserController@identification');//获取实名认证
        Route::post('identification', 'Api\V1\UserController@modifyIdentification');//提交实名认证

        /**
         * 社交账户
         */
        Route::group(['prefix' => 'social'], function () {
            Route::get('accounts', 'Api\V1\UserController@socialAccounts');//获取绑定的社交账户
            Route::delete('accounts/{provider}', 'Api\V1\UserController@destroySocial');//解绑
            Route::get('bind/{provider}', 'Api\V1\UserController@bindSocial');//绑定社交账户
        });
    });

});
