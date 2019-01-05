<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Utils\ISO3166;
use Illuminate\Http\Request;

/**
 * Class GeographicController
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class GeographicController extends Controller
{
    /**
     * 获取国家列表
     * @param Request $request
     * @return array
     */
    public function country(Request $request)
    {
        $items = ISO3166::$countries;
        $countries = [];
        foreach ($items as $code => $value) {
            $country = [
                'label' => ISO3166::country($code),
                'value' => $code
            ];
            $countries[] = $country;
        }
        return $countries;
    }

    /**
     * 获取省
     * @param Request $request
     * @return array
     */
    public function province(Request $request)
    {
        return [];
    }

    /**
     * 获取 市
     * @param Request $request
     * @return array
     */
    public function city(Request $request)
    {
        return [];
    }
}