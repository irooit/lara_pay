<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Models;

use App\Models\Relations\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * 支付模型
 * @property int $id
 * @property string $channel
 * @property string $type
 * @property string $subject
 * @property string $order_id
 * @property float $amount
 * @property string $currency
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

    /**
     * @var array 批量复制属性
     */
    public $fillable = [
        'app_id', 'paid', 'type', 'channel', 'amount', 'currency', 'subject', 'body', 'client_ip', 'extra', 'time_paid',
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
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function order()
    {
        return $this->morphTo();
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
        //TODO 发送 主题广播回调
        return $paid;
    }
}