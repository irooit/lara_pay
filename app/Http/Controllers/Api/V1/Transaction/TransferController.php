<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Transaction\TransferRequest;
use App\Http\Resources\Api\V1\Transaction\TransferResource;
use App\Models\TransactionTransfer;

/**
 * 企业转账
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TransferController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * 发起转账
     * @param TransferRequest $request
     * @return TransferResource
     */
    public function store(TransferRequest $request)
    {
        $data = $request->all();
        $transfer = TransactionTransfer::create($data);
        return new TransferResource($transfer);
    }
}