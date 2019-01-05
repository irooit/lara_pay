<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Http\Requests\Api\V1;


use App\Http\Requests\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class modifyPasswordRequest
 *
 * @property string $old_password
 * @property string $password
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ModifyPasswordRequest extends Request
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
            'old_password' => [
                'required',
                'string',
                'min:4',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user()->password)) {
                        return $fail($attribute . ' is invalid.');
                    }
                }
            ],
            'password' => 'required|string|min:6',
        ];
    }

}