<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Models;

use App\Models\Relations\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSocial
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $provider
 * @property string $social_id
 * @property string|null $name Name
 * @property string|null $nickname NickName
 * @property string|null $email email
 * @property string|null $avatar avatar
 * @property string|null $access_token
 * @property string|null $token_expires_at
 * @property string|null $refresh_token
 * @property array|null $data Data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $openid
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial byProvider($provider)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial bySocial($id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial bySocialAndProvider($id, $provider)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial byUser($userId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereSocialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereTokenExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereUserId($value)
 * @mixin \Eloquent
 */
class UserSocial extends Model
{
    use BelongsToUserTrait;

    const SERVICE_WEIXIN = 'weixin';
    const SERVICE_WEIXIN_WEB = 'weixinweb';
    const SERVICE_WEIXIN_MOBILE = 'weixin-mobile';
    const SERVICE_WEIXIN_MINI_PROGRAM = 'weixin-mini-program';
    const SERVICE_WEIBO = 'weibo';
    const SERVICE_QQ = 'qq';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_social_accounts';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'nickname', 'email', 'avatar', 'provider', 'social_id', 'access_token', 'data', 'token_expires_at', 'refresh_token'
    ];

    /**
     * 这个属性应该被转换为原生类型.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * 链接用户
     * @param User $user
     * @return bool
     */
    public function connect(User $user)
    {
        return $this->update(['user_id' => $user->id]);
    }

    /**
     * 获取OpenId
     *
     * @return string
     */
    public function getOpenidAttribute()
    {
        if (isset($this->data['openid'])) {
            return $this->data['openid'];
        }
        return null;
    }

    /**
     * 查询指定的提供商
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $id
     * @param string $provider
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySocialAndProvider($query, $id, $provider)
    {
        return $query->where('social_id', '=', $id)->where('provider', '=', $provider);
    }

    /**
     * 查询指定的提供商
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $provider
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByProvider($query, $provider)
    {
        return $query->where('provider', '=', $provider);
    }

    /**
     * Finds an account by id.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySocial($query, $id)
    {
        return $query->where('social_id', '=', $id);
    }

    /**
     * Finds an account by user_id.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param integer $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', '=', $userId);
    }
}