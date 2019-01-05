<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Services;

use App\Models\User;
use App\Models\UserSocial;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Class UserService
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserService
{
    /**
     * 通过登陆邮箱或手机号获取用户
     * @param string $emailOrMobile
     * @return User
     */
    public static function findByEmailOrMobile($emailOrMobile)
    {
        return (new User())->findForPassport($emailOrMobile);
    }

    /**
     * 重置用户密码
     *
     * @param User $user
     * @param  string $password
     * @return void
     */
    public static function resetPassword(User $user, $password)
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();
        event(new PasswordReset($user));
    }

    /**
     * 通过手机创建用户
     * @param int $phone
     * @param string $password
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public static function createByPhone($phone, $password)
    {
        return User::create([
            'username' => $phone,
            'phone' => $phone,
            'password' => Hash::make($password),
        ]);
    }

    /**
     * 通过用户名和邮箱创建用户
     * @param string $username
     * @param string $email
     * @param string $password
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public static function createByUsernameAndEmail($username, $email, $password)
    {
        return User::create([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }

    /**
     * 随机生成一个用户名
     * @param string $username 用户名
     * @return string
     */
    public static function generateUsername($username)
    {
        if (User::query()->where('username', '=', $username)->exists()) {
            $row = User::query()->max('id');
            $username = $username . ++$row;
        }
        return $username;
    }

    /**
     * Verify and retrieve user by sms verify code request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @param bool $autoRegistration 是否自动注册用户
     * @return User|null
     * @throws \Exception
     */
    public static function byPassportSmsRequest(Request $request, $autoRegistration = false)
    {
        Validator::make($request->all(), [
            'phone' => [
                'required',
                'min:11',
                'max:11',
                'regex:/^1[34578]{1}[\d]{9}$|^166[\d]{8}$|^19[89]{1}[\d]{8}$/',
            ],
            'verifyCode' => [
                'required',
                'min:4',
                'max:6',
                function ($attribute, $value, $fail) use ($request) {
                    if (!SmsVerifyCodeService::make($request->phone)->validate($value, false)) {
                        return $fail($attribute . ' is invalid.');
                    }
                },
            ]
        ])->validate();
        if (($user = User::phone($request->phone)->first()) != null) {
            if ($user->disabled) {//禁止掉的用户不允许通过 社交账户登录
                throw new \Exception(__('user.Your account has been blocked.'));
            }
        } else if ($autoRegistration && config('user.enableSmsAutoRegistration', false)) {
            $user = User::create([
                'username' => $request->phone,
                'phone' => $request->phone,
                'password' => '$2y$10$k1oLWrK0ocNHcgbxaxsgFOXzGRnR8j34lQPiX1QHcPHJy180APy.K'
            ]);
        }
        return $user;
    }

    /**
     * 获取社交账户
     * @param string $provider
     * @param \Laravel\Socialite\Contracts\User $socialUser
     * @param bool $autoRegistration 是否自动注册用户
     * @return UserSocial
     */
    public static function getSocialUser($provider, \Laravel\Socialite\Contracts\User $socialUser, $autoRegistration = false)
    {
        //对微信特别处理
        if (in_array($provider, [UserSocial::SERVICE_WEIXIN, UserSocial::SERVICE_WEIXIN_WEB, UserSocial::SERVICE_WEIXIN_MOBILE, UserSocial::SERVICE_WEIXIN_MINI_PROGRAM])
            && (isset($socialUser->unionid) && !empty($socialUser->unionid))) {
            $socialId = $socialUser->unionid;
        } else {
            $socialId = $socialUser->getId();
        }
        if (($social = UserSocial::bySocialAndProvider($socialId, $provider)->first()) == null) {
            $attributes = [
                'provider' => $provider,
                'social_id' => $socialId,
                'name' => $socialUser->getName(),
                'nickname' => $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(),
            ];
            if ($socialUser->user) {
                $attributes['data'] = $socialUser->user;
            }
            if ($socialUser->token) {
                $attributes['access_token'] = $socialUser->token;
            }
            if ($socialUser->expiresIn && is_int($socialUser->expiresIn)) {
                $attributes['token_expires_at'] = Carbon::now()->addSeconds($socialUser->expiresIn)->toDateTimeString();
            }
            if (isset($socialUser->refreshToken)) {
                $attributes['refresh_token'] = $socialUser->refreshToken;
            }
            $social = UserSocial::create($attributes);
        } else {
            if ($socialUser->user) {
                $social->update(['data' => $socialUser->user]);
            }
        }
        //社交账户自动注册用户
        if (!$social->user && $autoRegistration && config('user.enableSocialiteAutoRegistration', false)) {
            $userAttributes = ['username' => null, 'password' => Hash::make('')];
            if (!empty($attributes['name'])) {
                $userAttributes['username'] = static::generateUsername($attributes['name']);
            } else if (!empty($attributes['nickname'])) {
                $userAttributes['username'] = static::generateUsername($attributes['nickname']);
            }
            if (!empty($attributes['email'])) {
                $userAttributes['email'] = $attributes['email'];
            }
            $user = User::create($userAttributes);
            $social->connect($user);
            return self::getSocialUser($provider, $socialUser);
        }
        return $social;
    }

    /**
     * 计算用户头像子路径
     *
     * @param int $userId 用户ID
     * @return string
     */
    public static function getAvatarPath($userId)
    {
        return 'avatar' . '/' . static::generateSubPath($userId);
    }

    /**
     * 计算用户实名认证图片子路径
     *
     * @param int $userId 用户ID
     * @return string
     */
    public static function getIdentificationImagePath($userId)
    {
        return 'identification' . '/' . static::generateSubPath($userId);
    }

    /**
     * 计算子路径
     * @param int $userId
     * @return string
     */
    private static function generateSubPath($userId)
    {
        $id = sprintf("%09d", $userId);
        $dir1 = substr($id, 0, 3);
        $dir2 = substr($id, 3, 2);
        $dir3 = substr($id, 5, 2);
        return $dir1 . '/' . $dir2 . '/' . $dir3 . '/' . substr($userId, -2);
    }
}