<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Observers;

use App\Models\TransactionRefund;
use App\Services\TransactionService;

/**
 * Class TransactionRefundObserver
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TransactionRefundObserver
{
    /**
     * 生成流水号
     * @return int
     */
    private function generateRefundId()
    {
        $i = rand(0, 9999);
        do {
            if (9999 == $i) {
                $i = 0;
            }
            $i++;
            $id = time() . str_pad($i, 4, '0', STR_PAD_LEFT);
            $row = TransactionRefund::where('id', '=', $id)->exists();
        } while ($row);
        return $id;
    }

    /**
     * 创建前
     * @param TransactionRefund $charge
     */
    public function creating(TransactionRefund $charge)
    {
        $charge->id = $this->generateRefundId();
    }

    /**
     * 监听明细创建事件.
     *
     * @param  TransactionRefund $refund
     * @return void
     * @throws \Exception
     */
    public function created(TransactionRefund $refund)
    {
        $refund->charge->update(['refunded' => true, 'amount_refunded' => $refund->charge->amount_refunded + $refund->amount]);
        $refund->update(['charge_order_id' => $refund->charge->order_id]);
        $channel = TransactionService::getChannel($refund->charge->channel);
        if ($refund->charge->channel == 'weixin') {
            $refundAccount = 'REFUND_SOURCE_RECHARGE_FUNDS';
            if ($refund->funding_source == TransactionRefund::FUNDING_SOURCE_UNSETTLED) {
                $refundAccount = 'REFUND_SOURCE_UNSETTLED_FUNDS';
            }
            $order = [
                'out_refund_no' => $refund->id,
                'out_trade_no' => $refund->charge->id,
                'total_fee' => $refund->charge->amount,
                'refund_fee' => $refund->amount,
                'refund_fee_type' => $refund->charge->currency,
                'refund_desc' => $refund->description,
                'refund_account' => $refundAccount,
                'notify_url' => config('pay.wechat.refund_notify_url'),
                //'spbill_create_ip' => '60.208.112.178',
            ];
            try {
                $response = $channel->refund($order);
                $refund->update(['transaction_no' => $response->transaction_id, 'extra' => $response]);
            } catch (\Exception $exception) {//设置提现失败
                $refund->setFailure('FAIL', $exception->getMessage());
            }
        } else if ($refund->charge->channel == 'alipay') {

        }
    }
}