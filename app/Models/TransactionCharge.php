<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Models;

use App\Jobs\TransactionChargeCallbackJob;
use App\Models\Relations\BelongsToUserTrait;
use App\Services\TransactionService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Client;

/**
 * 支付模型
 * @property int $id
 * @property string $channel
 * @property string $type
 * @property string $subject
 * @property string $order_id
 * @property float $amount
 * @property string $currency
 * @property boolean $paid
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TransactionCharge extends Model
{
    use BelongsToUserTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_charges';

    protected $primaryKey = 'id';

    public $incrementing = false;

    /**
     * @var array 批量赋值属性
     */
    public $fillable = [
        'id','app_id', 'paid', 'type', 'channel', 'order_id', 'amount', 'currency', 'subject', 'body', 'client_ip', 'extra', 'time_paid',
        'time_expire', 'transaction_no', 'amount_refunded', 'failure_code', 'failure_msg', 'metadata',
        'credential', 'description'
    ];

    /**
     * 这个属性应该被转换为原生类型.
     *
     * @var array
     */
    protected $casts = [
        'paid' => 'boolean',
        'metadata' => 'array',
        'credential' => 'array',
    ];

    /**
     * Get the app relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * 设置交易凭证
     * @param string $transactionNo 支付渠道返回的交易流水号。
     * @param array $credential 支付凭证
     * @return bool
     */
    public function setCredential($transactionNo, $credential)
    {
        return (bool)$this->update(['transaction_no' => $transactionNo, 'credential' => $credential]);
    }

    /**
     * 设置支付错误
     * @param string $code
     * @param string $msg
     * @return bool
     */
    public function setFailure($code, $msg)
    {
        return (bool)$this->update(['failure_code' => $code, 'failure_msg' => $msg]);
    }

    /**
     * 设置已付款状态
     * @param string $transactionNo 支付渠道返回的交易流水号。
     * @return bool
     */
    public function setPaid($transactionNo)
    {
        if ($this->paid) {
            return true;
        }
        $paid = (bool)$this->update(['transaction_no' => $transactionNo, 'time_paid' => $this->freshTimestamp(), 'paid' => true]);
        Log::debug('system notify TransactionChargeCallbackJob');
        if ($this->app->notify_url) {
            TransactionChargeCallbackJob::dispatch($this->app->notify_url, $this->toArray());
        }
        return $paid;
    }

    /**
     * 获取网关支付实例
     * @return \Yansongda\Pay\Gateways\Alipay|\Yansongda\Pay\Gateways\Wechat|string
     * @throws Exception
     */
    public function getChannel()
    {
        return TransactionService::getChannel($this->channel);
    }
}