<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 50)->unique()->nullable();//用户名。
            $table->string('email', 64)->unique()->nullable();//邮箱
            $table->string('phone', 11)->unique()->nullable();//手机号码
            $table->string('avatar', 255)->nullable();//头像地址
            $table->boolean('disabled')->default(false)->nullable();//是否被禁用
            $table->decimal('balance', 12, 2)->default(0.00)->nullable();//可提现余额
            $table->unsignedInteger('integral')->default(0)->nullable();//积分
            $table->string('password', 100);
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
