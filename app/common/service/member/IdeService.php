<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\common\service\member;

use app\common\model\member\IdeModel;
use app\common\service\BaseService;

/**
 * 身份
 */
class IdeService extends BaseService
{
    public static function getModel(): IdeModel
    {
        return new IdeModel();
    }
}