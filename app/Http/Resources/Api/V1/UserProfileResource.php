<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Resource;

/**
 * Class UserProfileResource
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserProfileResource extends Resource
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
            'phone' => $this->phone,
            'username' => $this->username,
            'email' => $this->email,
            'identified' => $this->identified,
            'balance' => $this->balance,
            'integral' => $this->integral,
            'avatar' => $this->avatar,
            'gender' => $this->gender,
            'birthday' => $this->profile->birthday,
            'country_code' => $this->profile->country_code,
            'province_id' => $this->profile->province_id,
            'city_id' => $this->profile->city_id,
            'location' => $this->profile->location,
            'address' => $this->profile->address,
            'website' => $this->profile->website,
            'timezone' => $this->profile->timezone,
            'introduction' => $this->profile->introduction,
            'bio' => $this->profile->bio,
        ];
    }
}