<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //注册路由
        Passport::routes();

        //开启隐式授权令牌
        Passport::enableImplicitGrant();

        Passport::$ignoreCsrfToken = true;

        //设置令牌过期时间15天
        Passport::tokensExpireIn(now()->addDays(config('passport.tokens_expire_in')));

        //设置刷新令牌过期时间30天
        Passport::refreshTokensExpireIn(now()->addDays(config('passport.refreshTokensExpireIn')));
    }
}
