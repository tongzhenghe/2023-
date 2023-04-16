<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\common\cache\utils;

use think\facade\Cache;

/**
 * 邮件验证码缓存
 */
class CaptchaEmailCache
{
    // 缓存标签
    protected static $tag = 'captcha_email';
    // 缓存前缀
    protected static $prefix = 'captcha_email:';

    /**
     * 缓存键名
     *
     * @param string $email 邮箱
     * 
     * @return string
     */
    public static function key($email)
    {
        return self::$prefix . $email;
    }

    /**
     * 缓存设置
     *
     * @param string $email   邮箱
     * @param string $captcha 验证码
     * @param int    $ttl     有效时间（秒，0永久）
     * 
     * @return bool
     */
    public static function set($email, $setting, $ttl = 1800)
    {
        return Cache::set(self::key($email), $setting, $ttl);
    }

    /**
     * 缓存获取
     *
     * @param string $email 邮箱
     * 
     * @return array 验证码
     */
    public static function get($email)
    {
        return Cache::get(self::key($email));
    }

    /**
     * 缓存删除
     *
     * @param mixed $email 邮箱
     * 
     * @return bool
     */
    public static function del($email)
    {
        $ids = var_to_array($email);
        foreach ($ids as $v) {
            Cache::delete(self::key($v));
        }
        return true;
    }

    /**
     * 缓存清除
     * 
     * @return bool
     */
    public static function clear()
    {
        return Cache::tag(self::$tag)->clear();
    }
}
