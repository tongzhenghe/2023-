<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\common\model\member;

use think\Model;
use app\common\model\file\FileModel;
use app\common\service\member\SettingService;

/**
 * 会员管理模型
 */
class IdeModel extends Model
{
    // 表名
    protected $name = 'member_ide';

    public function setCreateTimeAttr($value): string
    {
        return datetime($value);
    }





}
