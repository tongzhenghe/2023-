<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\common\service\setting;

use EasyWeChat\Factory;
use think\facade\Config;
use app\common\service\utils\StringUtils;
use app\common\cache\setting\WechatCache;
use app\common\model\setting\WechatModel;

/**
 * 微信设置
 */
class WechatService
{
    /**
     * 公众号id
     * @var integer
     */
    private static $offi_id = 1;

    /**
     * 小程序id
     * @var integer
     */
    private static $mini_id = 2;

    /**
     * 添加、修改字段
     * @var array
     */
    public static $edit_field = [
        'name/s'              => '',
        'origin_id/s'         => '',
        'qrcode_id/d'         => 0,
        'appid/s'             => '',
        'appsecret/s'         => '',
        'token/s'             => '',
        'encoding_aes_key/s'  => '',
        'encoding_aes_type/d' => 1,
    ];

    /**
     * 公众号信息
     *
     * @return array
     */
    public static function offiInfo()
    {
        $id = self::$offi_id;

        $info = WechatCache::get($id);
        if (empty($info)) {
            $model = new WechatModel();
            $pk = $model->getPk();

            $info = $model->find($id);
            if (empty($info)) {
                $info[$pk]                = $id;
                $info['token']            = StringUtils::random(32);
                $info['encoding_aes_key'] = StringUtils::random(43);
                $info['create_uid']       = user_id();
                $info['create_time']      = datetime();
                $model->save($info);
                $info = $model->find($id);
            }
            $info = $info->append(['qrcode_url'])->toArray();

            $info['server_url'] = server_url() . '/api/setting.Wechat/access';

            WechatCache::set($id, $info);
        }

        return $info;
    }

    /**
     * 公众号修改
     *
     * @param array $param 公众号信息
     *
     * @return array
     */
    public static function offiEdit($param)
    {
        $model = new WechatModel();
        $id = self::$offi_id;

        $param['update_uid']  = user_id();
        $param['update_time'] = datetime();

        $info = $model->find($id);
        $res = $info->save($param);
        if (empty($res)) {
            exception();
        }

        WechatCache::del($id);

        return $param;
    }

    /**
     * 小程序信息
     *
     * @return array
     */
    public static function miniInfo()
    {
        $id = self::$mini_id;

        $info = WechatCache::get($id);
        if (empty($info)) {
            $model = new WechatModel();
            $pk = $model->getPk();

            $info = $model->find($id);
            if (empty($info)) {
                $info[$pk]           = $id;
                $info['create_uid']  = user_id();
                $info['create_time'] = datetime();
                $model->save($info);
                $info = $model->find($id);
            }
            $info = $info->append(['qrcode_url'])->toArray();

            WechatCache::set($id, $info);
        }

        return $info;
    }

    /**
     * 小程序修改
     *
     * @param array $param 小程序信息
     *
     * @return array
     */
    public static function miniEdit($param)
    {
        $model = new WechatModel();
        $id = self::$mini_id;

        $param['update_uid']  = user_id();
        $param['update_time'] = datetime();

        $info = $model->find($id);
        $res = $info->save($param);
        if (empty($res)) {
            exception();
        }

        WechatCache::del($id);

        return $param;
    }

    /**
     * 微信公众号
     * 
     * @param array $config 配置
     * 
     * @return Factory
     */
    public static function offi($config = [])
    {
        $offi_info = self::offiInfo();

        if (empty($offi_info['appid'])) {
            exception('公众号 appid 未设置');
        }
        if (empty($offi_info['appsecret'])) {
            exception('公众号 appsecret 未设置');
        }

        $log_channel = Config::get('app.app_debug') ? 'dev' : 'prod';

        $config_info = [
            /**
             * 账号基本信息，请从微信公众平台/开放平台获取
             */
            'app_id'  => $offi_info['appid'],              // AppID
            'secret'  => $offi_info['appsecret'],          // AppSecret
            'token'   => $offi_info['token'],              // Token
            'aes_key' => $offi_info['encoding_aes_key'],   // EncodingAESKey，兼容与安全模式下请一定要填写！！！

            /**
             * 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
             * 使用自定义类名时，构造函数将会接收一个 `EasyWeChat\Kernel\Http\Response` 实例
             */
            'response_type' => 'array',

            /**
             * 日志配置
             *
             * level: 日志级别, 可选为：debug/info/notice/warning/error/critical/alert/emergency
             * path：日志文件位置(绝对路径!!!)，要求可写权限
             */
            'log' => [
                'default' => $log_channel, // 默认使用的 channel，生产环境可以改为下面的 prod
                'channels' => [
                    // 测试环境
                    'dev' => [
                        'driver' => 'single',
                        'path' => runtime_path() . '/easywechat/' . date('Ym') . '/' . date('Ymd') . 'officialAccountDev.log',
                        'level' => 'debug',
                    ],
                    // 生产环境
                    'prod' => [
                        'driver' => 'daily',
                        'path' => runtime_path() . '/easywechat/' . date('Ym') . '/' . date('Ymd') . 'officialAccountProd.log',
                        'level' => 'info',
                        'days' => 30,
                    ],
                ],
            ],
        ];

        $config = array_merge($config_info, $config);

        $app = Factory::officialAccount($config);

        return $app;
    }

    /**
     * 微信小程序
     * 
     * @param array $config 配置
     * 
     * @return Factory
     */
    public static function mini($config = [])
    {
        $mini_info = self::miniInfo();

        if (empty($mini_info['appid'])) {
            exception('小程序 appid 未设置');
        }
        if (empty($mini_info['appsecret'])) {
            exception('小程序 appsecret 未设置');
        }

        $log_level = Config::get('app.app_debug') ? 'debug' : 'error';

        $config_info = [
            'app_id' => $mini_info['appid'],
            'secret' => $mini_info['appsecret'],

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            /**
             * 日志配置
             *
             * level: 日志级别, 可选为：debug/info/notice/warning/error/critical/alert/emergency
             * path：日志文件位置(绝对路径!!!)，要求可写权限
             */
            'log' => [
                'level' => $log_level,
                'file' => runtime_path() . '/easywechat/' . date('Ym') . '/' . date('Ymd') . 'miniProgram.log',
            ],
        ];

        $config = array_merge($config_info, $config);

        $app = Factory::miniProgram($config);

        return $app;
    }
}
