<?php

namespace app\admin\controller\talk;

use app\common\service\talk\TalkService;
use app\common\controller\BaseController;
use app\Request;
use think\response\Json;

/**
 * 话题
 */
class Index extends BaseController
{

    /**
     * @var TalkService
     */
    private $talkService;

    public function initialize()
    {
        parent::initialize();
        $this->talkService = new TalkService();
    }

    public function list()
    {
        return success($this->talkService->getAllData());
    }


    /**
     * 修改话题简介
     * @param Request $request
     * @throws \think\Exception
     */
    public function updateInfo(Request $request)
    {
        return success($this->talkService->updateInfoData($request->param()));
    }

    public function delete()
    {

    }

}