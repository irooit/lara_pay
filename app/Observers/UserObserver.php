<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Observers;

use App\Models\User;

/**
 * 全局用户观察者
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserObserver
{
    /**
     * 监听用户创建事件.
     *
     * @param  User $user
     * @return void
     */
    public function created(User $user)
    {
        $user->profile()->create();//创建Profile
        $user->extra()->create();//创建Extra
        $user->identification()->create();//创建 初始的实名认证
    }

    /**
     * 监听用户删除事件.
     *
     * @param  User $user
     * @return void
     */
    public function deleting(User $user)
    {
        $user->profile->delete();
        $user->extra->delete();
        $user->identification->delete();
    }
}
