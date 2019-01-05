<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Http\Controllers\Api\V1\Transaction;


use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class NotifyController
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class NotifyController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['charge','refund']);
    }

    /**
     * 退款通知
     * @param Request $request
     * @param string $channel
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     */
    public function refund(Request $request, $channel)
    {
        try {
            $pay = TransactionService::getChannel($channel);
            $params = $pay->verify(null, true); // 验签
            if ($channel == 'weixin') {
                if ($params['refund_status'] == 'SUCCESS') {//入账
                    $refund = TransactionService::getRefundById($params['out_refund_no']);
                    $refund->setRefunded($params['success_time'], $params);
                }
                Log::debug('Wechat refund notify', $params->all());
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return $pay->success();
    }

    /**
     * 收款通知
     * @param Request $request
     * @param string $channel
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     */
    public function charge(Request $request, $channel)
    {
        try {
            $pay = TransactionService::getChannel($channel);
            $params = $pay->verify(); // 验签
            if ($channel == 'weixin') {
                if ($params['return_code'] == 'SUCCESS') {//入账
                    $charge = TransactionService::getChargeById($params['out_trade_no']);
                    $charge->setPaid($params['transaction_id']);
                }
                Log::debug('Wechat notify', $params->all());
            } else if ($channel == 'alipay') {
                if ($params['trade_status'] == 'TRADE_SUCCESS' || $params['trade_status'] == 'TRADE_FINISHED') {
                    $charge = TransactionService::getChargeById($params['out_trade_no']);
                    $charge->setPaid($params['trade_no']);
                }
                Log::debug('Alipay notify', $params->all());
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return $pay->success();
    }
}