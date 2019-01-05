<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Resource;

/**
 * Class UserExtraResource
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserExtraResource extends Resource
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
        return $request->user()->extra->toArray();
    }
}