<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Http\Resources\Api\V1\Transaction;


use App\Http\Resources\Resource;

/**
 * Class TransferResource
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TransferResource extends Resource
{
    /**
     * 禁用资源包裹
     *
     * @var string
     */
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        return [
            'id' => $this->id,
            'app_id' => $this->app_id,
            'charge_id' => $this->charge_id,
            'amount' => $this->amount,
            'succeed' => $this->succeed,
            'status' => $this->status,
            'description' => $this->description,
            'failure_code' => $this->failure_code,
            'failure_msg' => $this->failure_msg,
            'charge_order_no' => $this->charge_order_no,
            'transaction_no' => $this->transaction_no,
            'funding_source' => $this->funding_source,
            'metadata' => $this->metadata,
            'extra' => $this->extra,
            'time_succeed' => $this->time_succeed,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}