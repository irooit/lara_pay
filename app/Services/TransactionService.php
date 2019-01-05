<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Services;

use App\Models\TransactionCharge;
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
     * 从交易里直接发起退款
     * @param string $description
     * @return bool
     */
    public function setRefund($description)
    {
        $refund = new TransactionRefund(['amount' => $this->amount, 'description' => $description]);
        if ($refund->save() && $this->setReversed()) {
            return true;
        }
        return false;
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