<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;
use App\Services\SmsVerifyCodeService;

/**
 * 手机号注册请求
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PhoneRegisterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => [
                'required',
                'max:11',
                'regex:/^1[34578]{1}[\d]{9}$|^166[\d]{8}$|^19[89]{1}[\d]{8}$/',
                'unique:users',
            ],
            'verifyCode' => [
                'required',
                'min:4',
                'max:6',
                function ($attribute, $value, $fail) {
                    if (!SmsVerifyCodeService::make($this->phone)->validate($value, false)) {
                        return $fail($attribute . ' is invalid.');
                    }
                },
            ],
            'password' => 'required|string|min:6',
        ];
    }
}