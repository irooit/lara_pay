<?php

namespace App\Models;

use App\Models\Relations\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 用户扩展资料
 *
 * @property int $user_id
 * @property string|null $login_ip
 * @property \Illuminate\Support\Carbon|null $login_at
 * @property int|null $login_num
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExtra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExtra newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserExtra onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExtra query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExtra whereLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExtra whereLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExtra whereLoginNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExtra whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserExtra withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserExtra withoutTrashed()
 * @mixin \Eloquent
 */
class UserExtra extends Model
{
    use BelongsToUserTrait, SoftDeletes;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_extras';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'login_ip', 'login_at', 'login_num'
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
     * 应该被转化为原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'login_num' => 'int'
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'login_at',
    ];
}
