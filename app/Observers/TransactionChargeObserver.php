<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Observers;

use App\Models\TransactionCharge;
use App\Services\TransactionService;

/**
 * Class TransactionChargeO
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TransactionChargeObserver
{
    /**
     * 生成流水号
     * @return int
     */
    private function generateChargeId()
    {
        $i = rand(0, 9999);
        do {
            if (9999 == $i) {
                $i = 0;
            }
            $i++;
            $id = time() . str_pad($i, 4, '0', STR_PAD_LEFT);
            $row = TransactionCharge::where('id', '=', $id)->exists();
        } while ($row);
        return $id;
    }

    /**
     * 创建前
     * @param TransactionCharge $charge
     */
    public function creating(TransactionCharge $charge)
    {
        $charge->id = $this->generateChargeId();
    }

    /**
     * 监听明细创建事件.
     *
     * @param  TransactionCharge $charge
     * @return void
     * @throws \Exception
     */
    public function created(TransactionCharge $charge)
    {
        $channel = TransactionService::getChannel($charge->channel);
        $order = [
            'out_trade_no' => $charge->id,
            'total_fee' => $charge->amount
        ];

        if ($charge->channel == 'weixin') {
            $order['body'] = $charge->body ?? $charge->subject;
        } else if ($charge->channel == 'alipay') {
            $order['subject'] = $charge->subject;
        }
        $credential = $channel->pay($charge->type, $order);

        if (in_array($charge->type, ['app', 'wap', 'web'])) {
            if ($charge->channel == 'weixin' && $charge->type == 'wap') {
                $credential = ['mweb' => $credential->getTargetUrl()];
            } else {
                $credential = ['params' => $credential->getContent()];
            }
        }
        $charge->update(['credential' => $credential]);

    }
}