<?php

namespace app\common\service\talk;

use app\common\model\talk\PrefixModel;
use app\common\service\BaseService;

/**
 * 话题管理
 */
class prefixService extends BaseService
{
    /**
     * @return PrefixModel
     */
    public static function getModel(): PrefixModel
    {
        return new PrefixModel();
    }

    public function getAll(): array
    {
       return $this->getAllData([], 1, 10, [], '', ['talk'], ['talk.title']);
    }
}
