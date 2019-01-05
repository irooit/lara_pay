<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Listeners\Auth;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Request;
use Laravel\Passport\Events\AccessTokenCreated;

/**
 * 通过Passport登录后，更新用户
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PruneUserExtra implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AccessTokenCreated $event
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        $user = User::find($event->userId);
        $user->extra->increment('login_num', 1, ['login_at' => date('Y-m-d H:i:s'), 'login_ip' => Request::ip()]);
        $user->loginHistories()->create(['ip' => Request::ip()]);
    }
}