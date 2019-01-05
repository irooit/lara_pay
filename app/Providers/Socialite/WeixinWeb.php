<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Providers\Socialite;

use Illuminate\Support\Arr;
use SocialiteProviders\Manager\OAuth2\User;
use SocialiteProviders\WeixinWeb\Provider;

/**
 * Class WexinWeb
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class WeixinWeb extends Provider
{
    /**
     * {@inheritdoc}.
     */
    protected function mapUserToObject(array $user)
    {

        return (new User())->setRaw($user)->map([
            'id' => Arr::get($user, 'openid'),
            'openid' => Arr::get($user, 'openid'),
            'unionid' => Arr::get($user, 'unionid'),
            'nickname' => Arr::get($user, 'nickname'),
            'avatar' => Arr::get($user, 'headimgurl'),
            'name' => null,
            'email' => null,
        ]);
    }
}