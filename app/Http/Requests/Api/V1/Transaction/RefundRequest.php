<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Http\Requests\Api\V1\Transaction;

use App\Http\Requests\Request;
use App\Services\TransactionService;

/**
 * Class RefundRequest
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class RefundRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool)$this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'app_id' => [
                'required', 'integer'
            ],
            'charge_id' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {//检查余额
                    $charge = TransactionService::getChargeById($this->charge_id);
                    if (!$charge->paid) {
                        return $fail('Unpaid, non-refundable.');
                    }
                }
            ],
            'description'=>[
                'required',
                'string',
            ],
            'amount' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {//检查余额
                    $charge = TransactionService::getChargeById($this->charge_id);
                    if ($charge->amount_refunded >= $this->amount) {//已退款的大于等于当前退款金额
                        return $fail('Already retired.');
                    } elseif (($charge->amount_refunded + $this->amount) > $charge->amount) {//多次退款总额超出
                        return $fail('Already retired.');
                    }
                }
            ],
        ];
    }


}