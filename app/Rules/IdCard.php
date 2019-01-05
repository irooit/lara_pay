<?php

namespace App\Rules;

use App\Utils\IDCardUtil;
use Illuminate\Contracts\Validation\Rule;

/**
 * 中国大陆居民身份证验证
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class IdCard implements Rule
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
        return IDCardUtil::validateCard($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        //return trans('validation.idCard');
        return ' Do not meet the rules.';
    }
}
