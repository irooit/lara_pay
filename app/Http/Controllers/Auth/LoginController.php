<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserSocial;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

/**
 * 用户登录
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * 登录后的页面转向
     * @return mixed
     */
    public function redirectTo()
    {
        return Session::pull('actions-redirect', $this->redirectPath());
    }

    /**
     * 二维码登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function qrcode(Request $request)
    {
        $code = $request->get('code',Str::random(40));
        $attributes = Cache::remember($code, 5, function () use ($code) {
            return [
                'code' => $code,
                'msg' => trans('user.PleaseScan'),
            ];
        });
        return response()->json($attributes);
    }

    /**
     * 显示登录表单
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if (!Session::has('actions-redirect')) {
            Session::put('actions-redirect', URL::previous());
        }
        return view('auth.login');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if (preg_match('/^1[34578]{1}[\d]{9}$|^166[\d]{8}$|^19[89]{1}[\d]{8}$/', $request->account)) {
            $credentials = ['phone' => $request->account, 'password' => $request->password, 'disabled' => false];
        } else {
            $credentials = ['email' => $request->account, 'password' => $request->password, 'disabled' => false];
        }
        $attempt = $this->guard()->attempt($credentials, true);
        return $attempt;
    }


    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptVerifyCodeLogin(Request $request)
    {
        $credentials = ['phone' => $request->phone, 'disabled' => false];
        $attempt = $this->guard()->attempt($credentials, true);
        return $attempt;
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($request->session()->has('social_id')) {//绑定请求
            UserSocial::find($request->session()->pull('social_id'))->connect($user);
        }
        // 记录用户登录次数和最后登录时间
        $user->extra->increment('login_num', 1, ['login_at' => date('Y-m-d H:i:s'), 'login_ip' => $request->ip()]);
        $user->getLoginHistories()->create(['ip' => $request->ip()]);
        return;
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'account';
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //返回注销前的页面
        return redirect()->back();
    }
}
