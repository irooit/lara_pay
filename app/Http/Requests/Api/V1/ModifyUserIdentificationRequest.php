<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Request;
use App\Rules\IdCard;

/**
 * 提交实名认证请求
 * @property string $real_name
 * @property int $id_type
 * @property string $id_card
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ModifyUserIdentificationRequest extends Request
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
            'real_name' => [
                'required',
                'string',
            ],
            'id_card' => [
                'required',
                'string',
                new IdCard(),
            ],
            'id_file' => [
                'required',
                'image',
            ],
            'id_file1' => [
                'required',
                'image',
            ],
            'id_file2' => [
                'required',
                'image',
            ],
        ];
    }
}