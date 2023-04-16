<?php

namespace app\common\model\talk;

use app\common\model\setting\RegionModel;
use think\Model;
use think\model\relation\BelongsTo;

class PrefixModel extends Model
{
    protected $name = 'talk_prefix';

    public const IS_NEED_AUTH = 1;
    public const NOT_NEED_AUTH = 0;

    public $needAuthMap = [
        self::IS_NEED_AUTH => '是',
        self::NOT_NEED_AUTH => '否',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(RegionModel::class, 'add_id');
    }
    public function talk(): BelongsTo
    {
        return $this->belongsTo(TalkModel::class, 'talk_id');
    }


}