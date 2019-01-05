<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Providers\Socialite;

use SocialiteProviders\Weixin\Provider;
use SocialiteProviders\Manager\OAuth2\User;

/**
 * Class Wexin
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Weixin extends Provider
{
    /**
     * {@inheritdoc}.
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['openid'],
            'unionid' => isset($user['unionid']) ? $user['unionid'] : null,
            'nickname' => isset($user['nickname']) ? $user['nickname'] : null,
            'avatar' => isset($user['headimgurl']) ? $user['headimgurl'] : null,
            'name' => null,
            'email' => null,
        ]);
    }

}