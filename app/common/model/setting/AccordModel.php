<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\common\model\setting;

use think\Model;
use hg\apidoc\annotation as Apidoc;

/**
 * 协议管理模型
 */
class AccordModel extends Model
{
    // 表名
    protected $name = 'setting_accord';
    // 表主键
    protected $pk = 'accord_id';
}
