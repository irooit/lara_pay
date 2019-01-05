<?php

namespace App\Models;

use App\Services\UserService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;
use League\OAuth2\Server\Exception\OAuthServerException;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $email
 * @property string|null $phone
 * @property string $avatar
 * @property bool|null $disabled
 * @property float|null $balance
 * @property int|null $integral
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $phone_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \App\Models\UserExtra $extra
 * @property-read bool $is_avatar
 * @property-read \App\Models\UserIdentification $identification
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserLoginHistory[] $loginHistories
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Models\UserProfile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserSocial[] $socials
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User normal()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User phone($phone)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIntegral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'phone', 'password', 'avatar', 'balance', 'integral'
    ];

    /**
     * 隐藏输出的属性
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 属性类型转换
     *
     * @var array
     */
    protected $casts = [
        'disabled' => 'boolean',
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at',
        'phone_verified_at'
    ];

    /**
     * 获取用户资料
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * 获取用户扩展资料
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function extra()
    {
        return $this->hasOne(UserExtra::class);
    }

    /**
     * 获取登录历史
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loginHistories()
    {
        return $this->hasMany(UserLoginHistory::class);
    }

    /**
     * 获取用户已经绑定的社交账户
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socials()
    {
        return $this->hasMany(UserSocial::class);
    }

    /**
     * 获取实名认证
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function identification()
    {
        return $this->hasOne(UserIdentification::class);
    }

    /**
     * 获取用户关注的标签
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNormal($query)
    {
        return $query->where('disabled', 0);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $phone
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePhone($query, $phone)
    {
        return $query->where('phone', '=', $phone);
    }

    /**
     * 返回头像Url
     * @return string
     */
    public function getAvatarAttribute()
    {
        if (!empty($this->attributes['avatar'])) {
            return Storage::disk(config('user.avatarDisk'))->url($this->attributes['avatar']);
        }
        return '';
    }

    /**
     * 是否有头像
     * @return boolean
     */
    public function getIsAvatarAttribute()
    {
        return !empty($this->attributes['avatar']);
    }

    /**
     * 是否经过实名认证。
     * @return int
     */
    public function getIdentified()
    {
        return $this->identification->status == UserIdentification::STATUS_IDENTIFIED;
    }

    /**
     * 发送邮箱验证通知
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        if (!is_null($this->email)) {
            $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
        }
    }

    /**
     * Verify and retrieve user by sms verify code request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function byPassportSmsRequest(Request $request)
    {
        try {
            return UserService::byPassportSmsRequest($request, true);
        } catch (\Exception $e) {
            throw OAuthServerException::accessDenied($e->getMessage());
        }
    }

    /**
     * 获取手机号
     * @return int
     */
    public function routeNotificationForPhone()
    {
        return $this->phone;
    }

    /**
     * Find user using social provider's user
     *
     * @param string $provider Provider name as requested from oauth e.g. facebook
     * @param \Laravel\Socialite\Contracts\User $socialUser User of social provider
     *
     * @return User
     * @throws \Exception
     */
    public static function findForPassportSocialite($provider, \Laravel\Socialite\Contracts\User $socialUser)
    {
        $social = UserService::getSocialUser($provider, $socialUser, true);
        if ($social && $social->user) {
            if ($social->user->disabled) {//禁止掉的用户不允许通过 社交账户登录
                throw new \Exception(__('user.Your account has been blocked.'));
            }
            return $social->user;
        }
        return null;
    }

    /**
     * @param string $username
     * @return mixed
     */
    public function findForPassport($username)
    {
        if (preg_match('/^1[34578]{1}[\d]{9}$|^166[\d]{8}$|^19[89]{1}[\d]{8}$/', $username)) {
            return static::normal()
                ->where('phone', $username)
                ->first();
        } else {
            return static::normal()
                ->where('email', $username)
                ->first();
        }
    }
}
