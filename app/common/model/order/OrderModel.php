<?php

namespace app\common\model\order;

use app\common\model\member\MemberModel;
use app\common\model\setting\RegionModel;
use think\Model;
use think\model\relation\BelongsTo;

class OrderModel extends Model
{
    // 表名
    protected $name = 'order';
    // 表主键
    protected $pk = 'order_id';

    public const TYPE_ONE = 1;
    public const TYPE_TOW = 2;
    public static $typeMap = [
        self::TYPE_ONE => '付费发布',
        self::TYPE_TOW => '会员发布',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(RegionModel::class, 'add_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(MemberModel::class, 'user_id');
    }
}
