<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MailVerifyCodeRequest;
use App\Http\Requests\Api\PhoneSmsVerifyCodeRequest;
use App\Http\Resources\Api\DnsRecordResource;
use App\Services\MailVerifyCodeService;
use App\Services\SmsVerifyCodeService;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

/**
 * Class MainController
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MainController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['SmsVerifyCode', 'MailVerifyCode']);
    }

    /**
     * 获取时区
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function timezone(Request $request)
    {
        $timezones = [];
        $identifiers = DateTimeZone::listIdentifiers();
        foreach ($identifiers as $identifier) {
            $date = new DateTime("now", new DateTimeZone($identifier));
            $offsetText = $date->format("P");
            $timezones[] = [
                "identifier" => $identifier,
                "label" => "(GMT{$offsetText}) $identifier",
            ];
        }
        return $timezones;
    }

    /**
     * 远程DNS解析
     * @param Request $request
     * @return DnsRecordResource
     */
    public function dnsRecord(Request $request)
    {
        $dnsRecord = dns_get_record($request->input('host'), DNS_A);
        if ($request->input('only-ip', false)) {
            return array_column($dnsRecord, 'ip');
        }
        return new DnsRecordResource($dnsRecord);
    }

    /**
     * 短信验证码
     * @param PhoneSmsVerifyCodeRequest $request
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function PhoneSmsVerifyCode(PhoneSmsVerifyCodeRequest $request)
    {
        $verifyCode = SmsVerifyCodeService::make($request->phone);
        $verifyCode->setIp($request->getClientIp());//记录客户端IP
        if ($verifyCode->getSendCount() > 9) {//限制每天只能发送10条（手机号的发送次数和IP的发送次数同时判断，任何一个或两者相加满足条件将拒绝发送）
            throw new TooManyRequestsHttpException('Too Many Requests.');
        }
        return $verifyCode->send();
    }

    /**
     * EMail验证码
     * @param MailVerifyCodeRequest $request
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function MailVerifyCode(MailVerifyCodeRequest $request)
    {
        $verifyCode = MailVerifyCodeService::make($request->email);
        $verifyCode->setIp($request->getClientIp());//记录客户端IP
        if ($verifyCode->getSendCount() > 9) {//限制每天只能发送10条（手机号的发送次数和IP的发送次数同时判断，任何一个或两者相加满足条件将拒绝发送）
            throw new TooManyRequestsHttpException('Too Many Requests.');
        }
        return $verifyCode->send();
    }
}