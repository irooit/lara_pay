<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\MailRegisterRequest;
use App\Http\Requests\Api\V1\ModifyAvatarRequest;
use App\Http\Requests\Api\V1\ModifyPasswordRequest;
use App\Http\Requests\Api\V1\ModifyProfileRequest;
use App\Http\Requests\Api\V1\ModifyUserIdentificationRequest;
use App\Http\Requests\Api\V1\PhoneRegisterRequest;
use App\Http\Requests\Api\V1\ResetPasswordByPhoneRequest;
use App\Http\Resources\Api\V1\UserExtraResource;
use App\Http\Resources\Api\V1\UserIdentificationResource;
use App\Http\Resources\Api\V1\UserProfileResource;
use App\Http\Resources\Api\V1\UserSocialResource;
use App\Models\User;
use App\Models\UserIdentification;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * 用户接口
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['phoneRegister', 'emailRegister', 'resetPasswordByPhone']);
    }

    /**
     * 手机注册接口
     * @param PhoneRegisterRequest $request
     * @return UserProfileResource
     */
    public function phoneRegister(PhoneRegisterRequest $request)
    {
        if (!config('user.enableRegistration')) {
            return response(__('user.The system has closed the new user registration.'), 403);
        }
        event(new Registered($user = UserService::createByPhone($request->phone, $request->password)));
        return new UserProfileResource($user);
    }

    /**
     * 邮箱注册接口
     * @param MailRegisterRequest $request
     * @return UserProfileResource
     */
    public function emailRegister(MailRegisterRequest $request)
    {
        if (!config('user.enableRegistration')) {
            return response(__('user.The system has closed the new user registration.'), 403);
        }
        event(new Registered($user = UserService::createByUsernameAndEmail($request->username, $request->email, $request->password)));
        return new UserProfileResource($user);
    }

    /**
     * 通过短信重置密码
     * @param ResetPasswordByPhoneRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function resetPasswordByPhone(ResetPasswordByPhoneRequest $request)
    {
        /** @var User $user */
        if (($user = User::query()->where('phone', '=', $request->phone)->first()) != null) {
            UserService::resetPassword($user, $request->password);
            return response('', 200);
        } else {
            throw new NotFoundHttpException("User not found.");
        }
    }

    /**
     * 获取个人资料
     * @router /api/v1/user/profile
     * @param Request $request
     * @return UserProfileResource
     */
    public function profile(Request $request)
    {
        return new UserProfileResource($request->user());
    }

    /**
     * 获取用户扩展信息
     * @router /api/v1/user/extra
     * @param Request $request
     * @return UserExtraResource
     */
    public function extra(Request $request)
    {
        return new UserExtraResource($request->user());
    }

    /**
     * 获取实名认证
     * @router /api/v1/user/identification
     * @param Request $request
     * @return UserIdentificationResource
     */
    public function identification(Request $request)
    {
        return new UserIdentificationResource($request->user()->identification);
    }

    /**
     * 提交修改实名认证
     * @router /api/v1/user/identification
     * @param ModifyUserIdentificationRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyIdentification(ModifyUserIdentificationRequest $request)
    {
        $idFile = $request->file('id_file');
        $idFile1 = $request->file('id_file1');
        $idFile2 = $request->file('id_file2');
        $path = UserService::getIdentificationImagePath($request->user()->id);
        $fileName = $idFile->hashName();
        $filePath = $idFile->storeAs($path, $fileName, config('user.identificationDisk'));
        $fileName1 = $idFile1->hashName();
        $filePath1 = $idFile1->storeAs($path, $fileName1, config('user.identificationDisk'));
        $fileName2 = $idFile2->hashName();
        $filePath2 = $idFile2->storeAs($path, $fileName2, config('user.identificationDisk'));

        $request->user()->identification->update([
            'real_name' => $request->real_name,
            'id_card' => $request->id_card,
            'passport_cover' => $filePath,
            'passport_person_page' => $filePath1,
            'passport_self_holding' => $filePath2,
            'status' => UserIdentification::STATUS_PENDING
        ]);
        return response('', 200);
    }

    /**
     * 修改个人资料
     * @router /api/v1/user/profile
     * @param ModifyProfileRequest $request
     * @return UserProfileResource
     */
    public function modifyProfile(ModifyProfileRequest $request)
    {
        $request->user()->profile->update($request->validated());
        $request->user()->update($request->only(['gender']));
        return new UserProfileResource($request->user());
    }

    /**
     * 修改头像接口
     * @param ModifyAvatarRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyAvatar(ModifyAvatarRequest $request)
    {
        $file = $request->file('avatar');
        $path = UserService::getAvatarPath($request->user()->id);
        $fileName = $file->hashName();
        $filePath = $file->storeAs($path, $fileName, config('user.avatarDisk'));
        $request->user()->update(['avatar' => $filePath]);
        return response('', 200);
    }

    /**
     * 修改密码接口
     * @param ModifyPasswordRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyPassword(ModifyPasswordRequest $request)
    {
        UserService::resetPassword($request->user(), $request->password);
        return response('', 200);
    }

    /**
     * 获取已经绑定的社交账户
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function socialAccounts(Request $request)
    {
        return UserSocialResource::collection($request->user()->socials);
    }

    /**
     * 解绑社交账户
     *
     * @param Request $request
     * @param string $provider
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroySocial(Request $request, $provider)
    {
        /** @var \App\Models\UserSocial $social */
        $social = $request->user()->socials()->where('provider', '=', $provider)->first();
        if ($social) {
            $social->delete();
            return response('', 204);
        }
        return response('Object not found.', 404);
    }

    /**
     * 绑定社交账户
     *
     * @param Request $request
     * @param string $provider
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function bindSocial(Request $request, $provider)
    {
        //获取社交 用户
        /** @var \Laravel\Socialite\Contracts\User $socialUser */
        $socialUser = Socialite::driver($provider)->stateless()->user();
        $social = UserService::getSocialUser($provider, $socialUser, false);
        $social->connect($request->user());
        return response('', 200);
    }
}