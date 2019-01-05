<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * 邮箱注册激活欢迎信
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserRegistrationWelcome extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * User 实例。
     *
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.welcome')
            ->subject('[' . config('app.name') . '] ' . __('email.WelcomeRegistration'));
    }
}
