<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace App\Utils;


use App\Models\BanWord;
use Illuminate\Support\Facades\Cache;

/**
 * Class BanUtil
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BanUtil
{
    const CACHE_TAG = 'system.ban.word';

    /**
     * 执行敏感词替换
     *
     * @param bool $refresh 是否刷新缓存
     * @param string $string 要检查的字符串
     * @return string 处理后的字符串
     */
    public static function replaceWord($string, $refresh = false)
    {
        $wordRaw = self::getBanWords($refresh);
        $words = array_combine($wordRaw, array_fill(0, count($wordRaw), '*'));
        return strtr($string, $words);
    }

    /**
     * 检查字符串是否包含敏感词
     *
     * @param bool $refresh 是否刷新缓存
     * @param string $string 要检查的字符串
     * @return bool
     */
    public static function checkWord($string, $refresh = false)
    {
        $words = self::getBanWords($refresh);
        foreach ($words as $word) {
            if (strlen($word) > 0 && stripos($string, $word) !== false) {
                return false;
            }
        }
        //没找到
        return true;
    }

    /**
     * 获取敏感词
     * @param bool $refresh 是否刷新缓存
     * @return array|mixed
     */
    public static function getBanWords($refresh = false)
    {
        if (config('app.debug') || $refresh || (($words = Cache::get(static::CACHE_TAG)) === null)) {
            $ws = BanWord::query()->select('word')->get()->toArray();
            $words = [];
            foreach ($ws as $w) {
                $words[] = $w['word'];
            }
            Cache::forever(static::CACHE_TAG, $words);
        }
        return $words;
    }

    /**
     * 使缓存无效
     */
    public static function invalidate()
    {
        Cache::forget(static::CACHE_TAG);
    }
}