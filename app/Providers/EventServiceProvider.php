<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use App\Listeners\Auth\PruneUserExtra;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Passport\Events\AccessTokenCreated;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        //社交账户事件
        SocialiteWasCalled::class => [
            'SocialiteProviders\QQ\QqExtendSocialite@handle',
            'App\Providers\Socialite\WeixinExtendSocialite@handle',
            'App\Providers\Socialite\WeixinWebExtendSocialite@handle',
            'App\Providers\Socialite\WeixinMobileExtendSocialite@handle',
            'SocialiteProviders\Weibo\WeiboExtendSocialite@handle',
        ],

        // Passport 事件
        AccessTokenCreated::class => [
            PruneUserExtra::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
