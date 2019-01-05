<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\Client;

/**
 * 退款处理模型
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TransactionRefund extends Model
{
    use SoftDeletes;
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

    protected $primaryKey = 'id';

    public $incrementing = false;

    /**
     * @var array 批量赋值属性
     */
    public $fillable = [
        'id', 'app_id', 'charge_id', 'amount', 'status', 'description', 'failure_code', 'failure_msg', 'charge_order_id', 'transaction_no', 'funding_source', 'metadata', 'extra', 'time_succeed'
    ];

    /**
     * 这个属性应该被转换为原生类型.
     *
     * @var array
     */
    protected $casts = [
        'succeed' => 'boolean',
        'metadata' => 'array',
        'extra' => 'array'
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'time_succeed',
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
     * 关联收单
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function charge()
    {
        return $this->belongsTo(TransactionCharge::class);
    }

    /**
     * 退款是否成功
     * @return bool
     */
    public function getSucceedAttribute()
    {
        return $this->status == self::STATUS_SUCCEEDED;
    }
}