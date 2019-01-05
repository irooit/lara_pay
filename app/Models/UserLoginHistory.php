<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Models;

use App\Models\Relations\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 登录历史
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @property int $id
 * @property int $user_id
 * @property string $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLoginHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLoginHistory newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserLoginHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLoginHistory query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLoginHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLoginHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLoginHistory whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLoginHistory whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserLoginHistory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserLoginHistory withoutTrashed()
 * @mixin \Eloquent
 */
class UserLoginHistory extends Model
{
    use BelongsToUserTrait, SoftDeletes;

    const UPDATED_AT = null;

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_login_history';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'ip'
    ];

    /**
     * 隐藏输出的属性
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
    ];
}