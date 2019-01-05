<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Client;

/**
 * 退款处理模型
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TransactionRefund extends Model
{
    //退款状态
    const STATUS_PENDING = 0b0;
    const STATUS_SUCCEEDED = 0b1;
    const STATUS_FAILED = 0b10;

    //退款资金来源
    const FUNDING_SOURCE_UNSETTLED = 'unsettled_funds';//使用未结算资金退款
    const FUNDING_SOURCE_RECHARGE = 'recharge_funds';//使用可用余额退款

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_refunds';

    /**
     * 这个属性应该被转换为原生类型.
     *
     * @var array
     */
    protected $casts = [
        'metadata' => 'array',
        'extra' => 'array'
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
     * Get the charge relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function charge()
    {
        return $this->belongsTo(TransactionCharge::class);
    }
}