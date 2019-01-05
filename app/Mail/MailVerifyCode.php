<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * 邮件验证码
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MailVerifyCode extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var string 邮件验证码
     */
    protected $verifyCode;

    /**
     * Create a new message instance.
     *
     * @param string $verifyCode
     */
    public function __construct($verifyCode)
    {
        $this->verifyCode = $verifyCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.verify_code')->with([
            'verifyCode' => $this->verifyCode,
        ])->subject('[' . config('app.name') . '] ' . __('email.VerifyCode'));
    }
}
