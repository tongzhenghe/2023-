<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\common\service\order;

use app\common\model\order\OrderModel;
use app\common\service\BaseService;

class OrderService extends BaseService
{
    public static function getModel(): OrderModel
    {
        return new OrderModel();
    }

    public function getAll(): array
    {
        return $this->getAllData([], 1, 10, [], '', ['user'], ['user.name']);
    }

}
