<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * 中国大陆手机号码验证
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PhoneNumber implements Rule
{
    /**
     * @var string the regular expression for matching mobile.
     */
    public $mobilePattern = '/^1[34578]{1}[\d]{9}$|^166[\d]{8}$|^19[89]{1}[\d]{8}$/';

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
        if (!preg_match($this->mobilePattern, $value)) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '{attribute} is invalid.';
    }
}
