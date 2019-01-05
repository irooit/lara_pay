<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Jobs;

use App\Sms\VerifyCodeMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * 推送短信验证码给用户
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SmsVerifyCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务可以尝试的最大次数。
     *
     * @var int
     */
    public $tries = 2;

    /**
     * 手机号
     * @var string
     */
    protected $mobile;

    /**
     * 验证码
     * @var string
     */
    protected $code;

    /**
     * Create a new job instance.
     *
     * @param string $mobile
     * @param string $code
     */
    public function __construct($mobile, $code)
    {
        $this->mobile = $mobile;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $message = new VerifyCodeMessage(['code' => $this->code]);
        $flag = sms()->send($this->mobile, $message);
        if ($flag == false) {
            throw new \Exception("Send Sms exception.");
        }
    }
}