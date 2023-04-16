<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\common\model\system;

use think\Model;
use app\common\model\file\FileModel;
use hg\apidoc\annotation as Apidoc;

/**
 * 用户管理模型
 */
class UserModel extends Model
{
    // 表名
    protected $name = 'system_user';
    // 表主键
    protected $pk = 'user_id';

    // 关联头像文件
    public function avatar()
    {
        return $this->hasOne(FileModel::class, 'file_id', 'avatar_id')->append(['file_url'])->where(where_disdel());
    }
    // 获取头像链接
    public function getAvatarUrlAttr()
    {
        return $this['avatar']['file_url'] ?? '';
    }

    // 关联部门
    public function depts()
    {
        return $this->belongsToMany(DeptModel::class, UserAttributesModel::class, 'dept_id', 'user_id');
    }
    // 获取部门id
    public function getDeptIdsAttr()
    {
        return relation_fields($this['depts'], 'dept_id');
    }
    // 获取部门名称
    public function getDeptNamesAttr()
    {
        return relation_fields($this['depts'], 'dept_name', true);
    }

    // 关联职位
    public function posts()
    {
        return $this->belongsToMany(PostModel::class, UserAttributesModel::class, 'post_id', 'user_id');
    }
    // 获取职位id
    public function getPostIdsAttr()
    {
        return relation_fields($this['posts'], 'post_id');
    }
    // 获取职位名称
    public function getPostNamesAttr()
    {
        return relation_fields($this['posts'], 'post_name', true);
    }

    // 关联角色
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, UserAttributesModel::class, 'role_id', 'user_id');
    }
    // 获取角色id
    public function getRoleIdsAttr()
    {
        return relation_fields($this['roles'], 'role_id');
    }
    // 获取角色名称
    public function getRoleNamesAttr()
    {
        return relation_fields($this['roles'], 'role_name', true);
    }
}
