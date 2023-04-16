<?php

namespace app\common\model\msg;

use app\common\model\setting\RegionModel;
use app\common\model\talk\PrefixModel;
use app\common\model\talk\TalkModel;
use think\Model;
use think\model\relation\BelongsTo;

class MsgModel extends Model
{
    protected $name = 'msg';
    protected $pk = 'msg_id';

    public function address(): BelongsTo
    {
        return $this->belongsTo(RegionModel::class, 'add_id');
    }
    public function talk(): BelongsTo
    {
        return $this->belongsTo(TalkModel::class, 'talk_id');
    }

    public function prefix(): BelongsTo
    {
        return $this->belongsTo(PrefixModel::class, 'prefix_id');
    }
}