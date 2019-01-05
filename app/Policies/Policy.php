<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * 授权策略基类
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Policy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }


//    public function before($user, $ability)
//    {
//
//    }
}