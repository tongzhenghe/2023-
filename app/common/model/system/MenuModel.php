<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\common\model\system;

use app\common\cache\system\MenuCache;
use think\Model;

/**
 * 菜单管理模型
 */
class MenuModel extends Model
{
    // 表名
    protected $name = 'system_menu';
    // 表主键
    protected $pk = 'menu_id';

    public  static function onAfterWrite()
    {
        MenuCache::clear();
    }
     public  static function onAfterDelete()
    {
        MenuCache::clear();
    }



}
