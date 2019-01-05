<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordByPhoneRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

    /**
     * 通过短信重置密码
     *
     * @param ResetPasswordByPhoneRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function resetPasswordByPhone(ResetPasswordByPhoneRequest $request)
    {
        /** @var User $user */
        if (($user = User::query()->where('phone', '=', $request->phone)->first()) != null) {
            $this->resetPassword($user,$request->password);
            /** @var \Illuminate\Http\Request  $request */
            return $this->sendResetResponse($request, trans('passwords.PasswordResetSucceeded'));
        } else {
            return redirect()->back()
                ->withInput($request->only('phone'));
                //->withErrors($request->messages());
        }
    }
}
