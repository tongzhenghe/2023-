<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\common\model\member;

use app\common\model\setting\RegionModel;
use think\Model;
use app\common\model\file\FileModel;
use app\common\service\member\SettingService;
use hg\apidoc\annotation as Apidoc;
use think\model\relation\BelongsTo;

/**
 * 会员管理模型
 */
class MemberModel extends Model
{
    // 表名
    protected $name = 'member';
    // 表主键
    protected $pk = 'member_id';
    public const IS = 1;
    public const NO = 0;

    public function address(): BelongsTo
    {
        return $this->belongsTo(RegionModel::class, 'add_id')->visible(['region_name']);
    }

    public function getIsMemberAttr($value): string
    {
        $isMemberMap = [
            self::IS => '是',
            self::NO => '否',
        ];
        return $isMemberMap[$value]??'';
    }
    /**
     * 获取性别名称
     * @Apidoc\Field("")
     * @Apidoc\AddField("gender_name", type="string", desc="性别名称")
     */
    public function getGenderNameAttr($value, $data)
    {
        return SettingService::genders($data['gender']);
    }

    /**
     * 获取注册渠道名称
     * @Apidoc\Field("")
     * @Apidoc\AddField("reg_channel_name", type="string", desc="注册渠道名称")
     */
    public function getRegChannelNameAttr($value, $data)
    {
        return SettingService::reg_channels($data['reg_channel']);
    }

    /**
     * 获取注册方式名称
     * @Apidoc\Field("")
     * @Apidoc\AddField("reg_type_name", type="string", desc="注册方式名称")
     */
    public function getRegTypeNameAttr($value, $data)
    {
        return SettingService::reg_types($data['reg_type']);
    }

    // 关联头像
    public function avatar()
    {
        return $this->hasOne(FileModel::class, 'file_id', '`avatar_id`')->append(['file_url'])->where(where_disdel());
    }

    public function ide()
    {
        return $this->belongsTo(IdeModel::class, 'ide_id')->hidden(['create_time', 'is_delete', 'update_time']);
    }

    /**
     * 获取头像链接
     * @Apidoc\Field("")
     * @Apidoc\AddField("avatar_url", type="string", desc="头像链接")
     */
    public function getAvatarUrlAttr($value, $data)
    {
        if (empty($data['headimgurl'])) {
            return $this['avatar']['file_url'] ?? '';
        }
        return $data['headimgurl'];
    }

    // 关联标签
    public function tags()
    {
        return $this->belongsToMany(TagModel::class, AttributesModel::class, 'tag_id', 'member_id');
    }
    /**
     * 获取标签id
     * @Apidoc\Field("")
     * @Apidoc\AddField("tag_ids", type="array", desc="标签id")
     */
    public function getTagIdsAttr()
    {
        return relation_fields($this['tags'], 'tag_id');
    }
    /**
     * 获取标签名称
     * @Apidoc\Field("")
     * @Apidoc\AddField("tag_names", type="string", desc="标签名称")
     */
    public function getTagNamesAttr()
    {
        return relation_fields($this['tags'], 'tag_name', true);
    }

    // 关联分组
    public function groups()
    {
        return $this->belongsToMany(GroupModel::class, AttributesModel::class, 'group_id', 'member_id');
    }
    /**
     * 获取分组id
     * @Apidoc\Field("")
     * @Apidoc\AddField("group_ids", type="array", desc="分组id")
     */
    public function getGroupIdsAttr()
    {
        return relation_fields($this['groups'], 'group_id');
    }
    /**
     * 获取分组名称
     * @Apidoc\Field("")
     * @Apidoc\AddField("group_names", type="string", desc="分组名称")
     */
    public function getGroupNamesAttr()
    {
        return relation_fields($this['groups'], 'group_name', true);
    }
}
