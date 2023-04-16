<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\api\middleware;

use Closure;
use think\Request;
use think\Response;
use think\facade\Config;
use app\common\service\member\SettingService;
use app\common\service\utils\RetCodeUtils;

/**
 * 接口校验中间件
 */
class ApiVerifyMiddleware
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        $setting = SettingService::info();

        // 会员接口是否开启
        if ($setting['is_member_api']) {
            $debug = Config::get('app.app_debug');

            // 接口是否存在
            if (!api_is_exist()) {
                $msg = 'api url error';
                if ($debug) {
                    $msg .= '：' . api_url();
                }
                exception($msg, RetCodeUtils::API_URL_ERROR);
            }

            // 接口是否已禁用
            if (api_is_disable()) {
                $msg = 'api is disable';
                if ($debug) {
                    $msg .= '：' . api_url();
                }
                exception($msg, RetCodeUtils::API_URL_ERROR);
            }
        }

        return $next($request);
    }
}
