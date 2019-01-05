<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Observers;

use App\Models\TransactionTransfer;
use App\Services\TransactionService;

/**
 * Class Transfer
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TransactionTransferObserver
{
    /**
     * 生成流水号
     * @return int
     */
    private function generateId()
    {
        $i = rand(0, 9999);
        do {
            if (9999 == $i) {
                $i = 0;
            }
            $i++;
            $id = time() . str_pad($i, 4, '0', STR_PAD_LEFT);
            $row = TransactionTransfer::where('id', '=', $id)->exists();
        } while ($row);
        return $id;
    }

    /**
     * 创建前
     * @param TransactionTransfer $transfer
     */
    public function creating(TransactionTransfer $transfer)
    {
        $transfer->id = $this->generateId();
    }

    /**
     * 监听明细创建事件.
     *
     * @param  TransactionTransfer $transfer
     * @return void
     * @throws \Exception
     */
    public function created(TransactionTransfer $transfer)
    {
        TransactionService::transfer($transfer);
    }
}