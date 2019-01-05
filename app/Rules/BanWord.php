<?php

namespace App\Rules;

use App\Utils\BanUtil;
use Illuminate\Contracts\Validation\Rule;

/**
 * 敏感词检测
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BanWord implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_array($value)) {
            return false;
        }
        return BanUtil::checkWord($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ' Do not meet the rules.';
    }
}
