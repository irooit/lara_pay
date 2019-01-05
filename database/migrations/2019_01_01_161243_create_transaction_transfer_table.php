<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_transfer', function (Blueprint $table) {
            $table->string('id',64)->unique();
            $table->unsignedInteger('app_id');//收款的App ID
            $table->string('channel',64);//付款渠道

            $table->string('status',15)->default('scheduled')->nullable();//付款状态。目前支持 4 种状态：pending: 处理中; paid: 付款成功; failed: 付款失败; scheduled: 待发送。
            $table->string('order_id',64);//款使用的商户内部订单号。
            // wx/wx_pub/wx_lite 规定为 1 ~ 32 位不能重复的数字字母组合;
            // alipay 为 1 ~ 64 位不能重复的数字字母组合;
            $table->unsignedInteger('amount');//付款金额
            $table->string('currency',3);//三位 ISO 货币代码，目前仅支持人民币 cny。
            $table->string('recipient_id');//接收者 id，使用微信企业付款到零钱时为用户在  wx 、 wx_pub 及  wx_lite 渠道下的  open_id ，使用企业付款到银行卡时不需要此参数；
            $table->string('description',191)->nullable();//备注信息
            //渠道为  wx 、 wx_pub 、 wx_lite 时，最多 99 个英文和数字的组合或最多 33 个中文字符，不可以包含特殊字符；
            //渠道为  alipay 和  jdpay 时，最多 100 个 Unicode 字符；

            $table->string('transaction_no',64)->nullable();//交易流水号，由第三方渠道提供。
            $table->string('failure_msg')->nullable();//企业付款订单的错误消息的描述。
            $table->json('metadata')->nullable();//元数据
            $table->json('extra')->nullable();//附加参数
            $table->timestamp('transferred_at', 0)->nullable();//交易完成时间
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_transfer');
    }
}
