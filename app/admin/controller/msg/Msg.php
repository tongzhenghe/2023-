<?php

namespace app\admin\controller\msg;

use app\common\controller\BaseController;
use app\common\service\msg\MsgService;
use app\Request;

class Msg extends BaseController
{

    /**
     * @var MsgService
     */
    private $msgService;

    public function initialize()
    {
        parent::initialize();
        $this->msgService = new MsgService();
    }

    public function list()
    {
        return success($this->msgService->getAllData());
    }

    /**
     * 审核
     * @param Request $request
     * @throws \think\Exception
     */
    public function approve(Request $request)
    {
        return success($this->msgService->approveMsg($request->param()));
    }

    public function delete()
    {

    }

}