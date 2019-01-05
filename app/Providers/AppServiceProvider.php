<?php

namespace App\Providers;

use App\Models\Tag;
use App\Models\TransactionCharge;
use App\Models\TransactionRefund;
use App\Models\TransactionTransfer;
use App\Models\User;
use App\Observers\TransactionChargeObserver;
use App\Observers\TransactionRefundObserver;
use App\Observers\TransactionTransferObserver;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //设置迁移的 string 字段默认长度是 191
        Schema::defaultStringLength(191);
        //关闭 API 响应的 data 包裹
        Resource::withoutWrapping();
        User::observe(UserObserver::class);
        TransactionCharge::observe(TransactionChargeObserver::class);
        TransactionRefund::observe(TransactionRefundObserver::class);
        TransactionTransfer::observe(TransactionTransferObserver::class);
        //多态映射表
//        Relation::morphMap([
//            'tags' => Tag::class,
//            'videos' => 'App\Video',
//        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //忽略 Passport 默认迁移
        Passport::ignoreMigrations();
        //
    }
}
