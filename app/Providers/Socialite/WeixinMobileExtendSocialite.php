<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Providers\Socialite;

use SocialiteProviders\Manager\SocialiteWasCalled;

/**
 * Class WeixinMobileExtendSocialite
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class WeixinMobileExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'weixin-mobile', __NAMESPACE__.'\WeixinMobile'
        );
    }
}