<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Services;

use App\Models\TransactionCharge;
use App\Models\TransactionRefund;
use App\Models\TransactionTransfer;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Yansongda\LaravelPay\Facades\Pay;

/**
 * Class TransactionService
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TransactionService
{
    /**
     * 获取交易渠道
     * @param string $channel
     * @return \Yansongda\Pay\Gateways\Alipay|\Yansongda\Pay\Gateways\Wechat
     * @throws Exception
     */
    public static function getChannel($channel)
    {
        if ($channel == 'weixin') {
            return Pay::wechat();
        } else if ($channel == 'alipay') {
            return Pay::alipay();
        } else {
            throw new Exception ('The channel does not exist.');
        }
    }

    /**
     * 获取支付单
     * @param int $id
     * @return TransactionCharge
     * @throws NotFoundHttpException
     */
    public static function getChargeById($id)
    {
        if (($model = TransactionCharge::find($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested charge does not exist.');
        }
    }

    /**
     * 获取退款单
     * @param int $id
     * @return TransactionRefund
     * @throws NotFoundHttpException
     */
    public static function getRefundById($id)
    {
        if (($model = TransactionRefund::find($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested charge does not exist.');
        }
    }

    /**
     * 发起企业付款
     * @param TransactionTransfer $transfer
     * @return TransactionTransfer
     * @throws Exception
     */
    public static function transfer(TransactionTransfer $transfer)
    {
        $channel = TransactionService::getChannel($transfer->channel);
        if ($transfer->channel == 'weixin') {
            $metadata = $transfer->metadata;
            $config = [
                'partner_trade_no' => $transfer->id,
                'openid' => $transfer->recipient_id,
                'check_name' => 'NO_CHECK',
                'amount' => $transfer->amount,
                'desc' => $transfer->description,
                'type' => $transfer->metadata['type'],
            ];

            if (isset($metadata['check_name']) && $metadata['check_name'] != 'NO_CHECK') {
                $config['check_name'] = $metadata['check_name'];
                $config['re_user_name'] = $metadata['re_user_name'];
            }
            try {
                $response = $channel->transfer($config);
                $transfer->update(['transaction_no' => $response->payment_no, 'transferred_at' => $response->payment_time, 'extra' => $response]);
            } catch (\Exception $exception) {//设置提现失败
                $transfer->setFailure('FAIL', $exception->getMessage());
            }
        }
        return $transfer;
    }

    /**
     * 发起退款
     * @param TransactionRefund $refund
     * @return TransactionRefund
     * @throws Exception
     */
    public static function refund(TransactionRefund $refund)
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
        } else if ($refund->charge->channel == 'alipay') {//TODO

        }

        return $refund;
    }

    /**
     * 关闭支付
     * @param string $id
     * @return TransactionCharge
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     * @throws \Yansongda\Pay\Exceptions\InvalidConfigException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public static function closeCharge($id)
    {
        $charge = static::getChargeById($id);
        if (!$charge->reversed && $charge->paid) {
            $charge->update(['failure_code' => 'FAIL', 'failure_msg' => '已支付，无法撤销']);
            return $charge;
        } else if (!$charge->reversed) {
            $channel = static::getChannel($charge->channel);
            $channel->close($charge->id);
            $charge->update(['reversed' => true, 'credential' => []]);
        }
        return $charge;
    }
}