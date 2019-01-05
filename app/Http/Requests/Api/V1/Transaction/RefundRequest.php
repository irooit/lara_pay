<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Http\Requests\Api\V1\Transaction;

use App\Http\Requests\Request;
use App\Models\TransactionRefund;

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
                'required', 'string'
            ],
            'amount' => [
                'required', 'string'
            ],
        ];
    }


}