<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Transaction\RefundRequest;
use App\Http\Resources\Api\V1\Transaction\RefundResource;
use App\Models\TransactionRefund;

/**
 * Class RefundController
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class RefundController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['notify']);
    }

    /**
     * 发起退款
     * @param RefundRequest $request
     * @return RefundResource
     */
    public function store(RefundRequest $request)
    {
        $data = $request->all();
        $data['funding_source'] = TransactionRefund::FUNDING_SOURCE_UNSETTLED;
        $refund = TransactionRefund::create($data);
        return new RefundResource($refund);
    }
}