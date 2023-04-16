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
use hg\apidoc\annotation as Apidoc;

/**
 * 会员日志模型
 */
class LogModel extends Model
{
    // 表名
    protected $name = 'member_log';
    // 表主键
    protected $pk = 'log_id';

    // 修改请求参数
    public function setRequestParamAttr($value)
    {
        return serialize($value);
    }
    // 获取请求参数
    public function getRequestParamAttr($value)
    {
        return unserialize($value);
    }

    // 关联会员
    public function member()
    {
        return $this->hasOne(MemberModel::class, 'member_id', 'member_id');
    }
    // 获取会员昵称
    public function getNicknameAttr($value)
    {
        return $this['member']['nickname'] ?? '';
    }
    // 获取会员用户名
    public function getUsernameAttr($value)
    {
        return $this['member']['username'] ?? '';
    }

    // 关联会员接口
    public function api()
    {
        return $this->hasOne(ApiModel::class, 'api_id', 'api_id');
    }
    // 获取会员接口链接
    public function getApiUrlAttr($value)
    {
        return $this['api']['api_url'] ?? '';
    }
    // 获取会员接口名称
    public function getApiNameAttr($value)
    {
        return $this['api']['api_name'] ?? '';
    }
}
