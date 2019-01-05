<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

/**
 * 找回密码
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 显示邮件找回密码链接
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        if (!config('user.enablePasswordRecovery')) {
            return redirect(url()->previous())->with('status', trans('user.closed_password_forgot'));
        }
        return view('auth.passwords.email');
    }

    /**
     * 显示手机号重置密码页面
     *
     * @return \Illuminate\Http\Response
     */
    public function showPhoneRequestForm()
    {
        if (!config('user.enablePasswordRecovery')) {
            return redirect(url()->previous())->with('status', trans('user.closed_password_forgot'));
        }
        Session::put('actions-redirect', Url::previous());
        return view('auth.passwords.phone');
    }
}
