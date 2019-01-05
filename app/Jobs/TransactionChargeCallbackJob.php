<?php
/**
 * @copyright Copyright (c) 2018 Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use XuTL\Supports\HttpClient;

/**
 * Class TransactionChargeCallbackJob
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TransactionChargeCallbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务可以尝试的最大次数。
     *
     * @var int
     */
    public $tries = 20;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * 回调载荷
     * @var array
     */
    protected $payload;

    /**
     * Create a new job instance.
     *
     * @param array $payload
     */
    public function __construct($endpoint, $payload)
    {
        $this->endpoint = $endpoint;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $http = new HttpClient();
        try {
            $http->postXML($this->endpoint, $this->payload);
        } catch (\Exception $e) {
            //记录失败到数据库
        }
    }
}