<?php

namespace App\Models;

use App\Models\Relations\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 用户实名认证
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @property int $user_id
 * @property string|null $real_name Real Name
 * @property string|null $id_card
 * @property string|null $passport_cover
 * @property string|null $passport_person_page
 * @property string|null $passport_self_holding
 * @property int|null $status
 * @property string|null $failed_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserIdentification onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification whereFailedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification wherePassportCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification wherePassportPersonPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification wherePassportSelfHolding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIdentification whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserIdentification withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserIdentification withoutTrashed()
 * @mixin \Eloquent
 */
class UserIdentification extends Model
{
    use BelongsToUserTrait, SoftDeletes;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_identification';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'real_name', 'id_card', 'passport_cover', 'passport_person_page', 'passport_self_holding', 'status', 'failed_reason'
    ];

    /**
     * 隐藏输出的属性
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];

    //认证状态
    const STATUS_UNSUBMITTED = 0b0;//暂未提交，初始状态
    const STATUS_PENDING = 0b1;//等待认证
    const STATUS_REJECTED = 0b10;//认证被拒绝
    const STATUS_IDENTIFIED = 0b11;//已经认证
}
