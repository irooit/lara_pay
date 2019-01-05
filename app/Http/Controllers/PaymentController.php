<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class PaymentController
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PaymentController
{
    public function paymentCallback(Request $request, $channel)
    {
        try {
            $pay = TransactionService::getChannel($channel);
            $params = $pay->verify(); // 验签
            if ($channel == 'alipay') {
                if ($params['trade_status'] == 'TRADE_SUCCESS' || $params['trade_status'] == 'TRADE_FINISHED') {
                    $charge = TransactionService::getChargeById($params['out_trade_no']);
                    $charge->setPaid($params['trade_no']);
                }
                Log::debug('Alipay return', $params->all());
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}