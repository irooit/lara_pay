<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BanWord
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BanWord extends Model
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'banwords';

    public $timestamps = false;

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'work'
    ];
}