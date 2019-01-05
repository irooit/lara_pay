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
        TransactionService::refund($refund);
    }
}