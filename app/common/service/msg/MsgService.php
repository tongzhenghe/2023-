<?php

namespace app\common\service\msg;

use app\common\model\msg\MsgModel;
use app\common\service\BaseService;

/**
 * 话题管理
 */
class MsgService extends BaseService
{
    public static function getModel(): MsgModel
    {
        return new MsgModel();
    }

    public function approveMsg($params)
    {
        $ids = explode(',', $params['ids']);
        unset( $params['ids']);
        return $this->updateData([[self::getModel()->getPk(), 'in', $ids]], $params);
    }
}
