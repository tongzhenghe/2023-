<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\order;

use app\common\controller\BaseController;
use app\common\service\order\OrderService;
use think\App;

class Order extends BaseController
{
    private $orderService;

    public function initialize()
    {
        parent::initialize();
        $this->orderService = new OrderService();
    }

    public function list()
    {
        return success($this->orderService->getAll());
    }
}