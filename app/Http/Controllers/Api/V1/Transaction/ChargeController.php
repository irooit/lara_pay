<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Http\Controllers\Api\V1\Transaction;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Transaction\ChargeRequest;
use App\Http\Resources\Api\V1\Transaction\ChargeResource;
use App\Models\TransactionCharge;
use App\Services\TransactionService;
use Illuminate\Http\Request;

/**
 * Class ChargeController
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ChargeController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['notify']);
    }

    /**
     * 创建收款
     * @param ChargeRequest $request
     * @return ChargeResource
     */
    public function store(ChargeRequest $request)
    {
        $data = $request->all();
        $data['client_ip'] = $request->getClientIp();
        $charge = TransactionCharge::create($data);
        return new ChargeResource($charge);
    }

    /**
     * 查询交易状态
     * @param Request $request
     * @param string $id
     * @return ChargeResource
     */
    public function query(Request $request, $id)
    {
        $charge = TransactionService::getChargeById($id);
        return new ChargeResource($charge);
    }

    /**
     * 关闭订单
     * @param Request $request
     * @param string $id
     * @return ChargeResource
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     * @throws \Yansongda\Pay\Exceptions\InvalidConfigException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function close(Request $request, $id)
    {
        $charge = TransactionService::closeCharge($id);
        return new ChargeResource($charge);
    }
}