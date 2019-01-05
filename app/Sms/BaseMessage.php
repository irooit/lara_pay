<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Sms;

use Overtrue\EasySms\Message;
use Overtrue\EasySms\Strategies\OrderStrategy;

/**
 * 短消息基类
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaseMessage extends Message
{
    /**
     * @var string 发送顺序
     */
    protected $strategy = OrderStrategy::class;
}