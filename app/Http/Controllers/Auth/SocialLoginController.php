<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserSocial;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class SocialLoginController
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SocialLoginController extends Controller
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        //跳转到登录前页面
        return Session::pull('actions-redirect', config('app.url'));
    }

    /**
     * 社交账户登录
     * @param  \Illuminate\Http\Request $request
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(Request $request, $provider)
    {
        try {
            if (!$request->session()->has('actions-redirect')) {
                $request->session()->put('actions-redirect', Url::previous());
            }
            return Socialite::driver($provider)->redirect();
        } catch (\InvalidArgumentException $e) {
            return redirect($this->redirectTo())->with('status', trans('user.NotSupportedYet'));
        }
    }

    /**
     * 社交账户回调
     * @param  \Illuminate\Http\Request $request
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        /** @var \Laravel\Socialite\Contracts\User $socialUser */
        $socialUser = Socialite::driver($provider)->user();
        $social = UserService::getSocialUser($provider, $socialUser);
        if ($social->user == null) {//用户未绑定
            if ($request->user()) {//已经登录，自动绑定
                $social->connect($request->user());
                return redirect($this->redirectTo());
            } else {
                $request->session()->put('social_id', $social->id);
                return redirect("/auth/social/{$provider}/binding", 302);
            }
        } else {//如果已经绑定过了账户，这里检查用户是否被禁用
            if ($social->user->disabled) {
                return redirect('/login')->with('status', trans('user.YourAccountHasBeenBlocked'));
            } else {
                //检查用户是否设置了微信提现通道
                if (UserSocial::SERVICE_WEIXIN == $provider && $social->user->settleAccounts()->where(['channel' => $provider])->first() == null) {
                    $social->user->settleAccounts()->create([
                        'channel' => $provider,
                        'recipient' => [
                            'openid' => $socialUser->getId(),//真实姓名
                            //'re_user_name' => '',//真实姓名
                        ],
                    ]);
                }
                Auth::login($social->user);
                return redirect($this->redirectTo());
            }
        }
    }

    /**
     * 绑定社交账户
     * @param Request $request
     * @param string $provider
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function handleProviderBinding(Request $request, $provider)
    {
        return view('auth.binding');
    }
}