<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 企业付款模型，处理提现
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TransactionTransfer extends Model
{
    use SoftDeletes;

    //付款状态
    const STATUS_SCHEDULED = 'scheduled';//scheduled: 待发送
    const STATUS_PENDING = 'pending';//pending: 处理中
    const STATUS_PAID = 'paid';//paid: 付款成功
    const STATUS_FAILED = 'failed';//failed: 付款失败

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_transfer';

    protected $primaryKey = 'id';

    public $incrementing = false;

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
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'transferred_at',
    ];
}