<?php

namespace app\common\model\talk;

use app\common\model\setting\RegionModel;
use think\Model;
use think\model\relation\BelongsTo;

class TalkModel extends Model
{
    protected $name = 'talk';
    /**
     * 关联地址
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(RegionModel::class, 'add_id');
    }
}