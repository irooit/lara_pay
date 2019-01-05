<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PhoneRegisterRequest;
use App\Mail\UserRegistrationWelcome;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

/**
 * 前台用户注册
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
     * Show the application registration form.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        if ($request->user()) {
            return redirect(url()->previous());
        } else if (!config('user.enableRegistration')) {
            return redirect(url()->previous())->with('status', trans('user.closedRegister'));
        }
        Session::put('actions-redirect', URL::previous());
        return view('auth.register');
    }

    /**
     * Show the application registration form.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showPhoneRegistrationForm(Request $request)
    {
        if ($request->user()) {
            return redirect(url()->previous());
        } else if (!config('user.enableRegistration')) {
            return redirect(url()->previous())->with('status', trans('user.closedRegister'));
        }
        Session::put('actions-redirect', Url::previous());
        return view('auth.phone-register');
    }

    /**
     * 手机注册
     * @param PhoneRegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function phoneRegister(PhoneRegisterRequest $request)
    {
        event(new Registered($user = UserService::createByPhone($request->post('phone'), $request->post('password'))));
        $this->guard()->login($user);
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return UserService::createByUsernameAndEmail($data['username'], $data['email'], $data['password']);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if (config('user.enableWelcomeEmail') && !empty($user->email)) {//发送欢迎邮件
            Mail::to($user->email)->queue(new UserRegistrationWelcome($user));
        }
        return;
    }
}
