<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Request;

/**
 * 修改个人资料
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ModifyProfileRequest extends Request
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
            'birthday' => 'sometimes|date_format:Y-m-d',
            'gender' => 'nullable|integer|min:0|max:2',
            'country_code' => 'nullable|string',
            'province_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'location' => 'nullable|string',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'timezone' => 'nullable|timezone',
            'introduction' => 'nullable|string',
            'bio' => 'nullable|string',
        ];
    }
}