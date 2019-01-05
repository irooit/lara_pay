<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Models\Relations;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait BelongsToUserTrait
 * @property Model $this
 *
 * @package App\Models\Relations
 */
trait BelongsToUserTrait
{
    /**
     * Get the user relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
