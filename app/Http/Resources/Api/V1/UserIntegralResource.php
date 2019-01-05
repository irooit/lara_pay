<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Resource;

/**
 * Class UserIntegralResource
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserIntegralResource extends Resource
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
        return [
            'id' => $this->id,
            'integral' => $this->integral,
            'current_integral' => $this->current_integral,
            'description' => $this->description,
            'type' => $this->type,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}