<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\setting;

use app\common\controller\BaseController;
use app\common\validate\setting\SettingValidate;
use app\common\service\setting\SettingService;
use app\Request;
use hg\apidoc\annotation as Apidoc;

/**
 * @Apidoc\Title("设置管理")
 * @Apidoc\Group("setting")
 * @Apidoc\Sort("700")
 */
class Rule extends BaseController
{

    /**
     * @param Request $request
     * @return false|int
     */
    public function setting(Request $request)
    {
        $file = '../config/rule.php';
        $params = $request->param();
        $string = '<?php 
return ' . var_export($params, true) . ';?>';
        return file_put_contents($file, $string);
    }

    /**
     * @return mixed
     */
    public function getRule()
    {
        return success((array)require('../config/rule.php'));
    }
}
