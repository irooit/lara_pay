<?php

namespace App\Models;

use App\Models\Relations\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 用户资料模型
 *
 * @property int $user_id
 * @property string|null $birthday
 * @property string|null $country_code
 * @property int|null $gender
 * @property int|null $province_id
 * @property int|null $city_id
 * @property string|null $location
 * @property string|null $address
 * @property string|null $website
 * @property string|null $timezone
 * @property string|null $introduction
 * @property string|null $bio
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProfile whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile withoutTrashed()
 * @mixin \Eloquent
 */
class UserProfile extends Model
{
    use BelongsToUserTrait, SoftDeletes;

    /**
     * @var bool
     */
    public $timestamps = false;

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_profiles';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'gender', 'birthday', 'country_code', 'province_id', 'city_id', 'location', 'address', 'website', 'timezone', 'introduction', 'bio'
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
        'province_id' => 'int',
        'city_id' => 'int',
    ];
}
