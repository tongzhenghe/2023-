<?php

namespace app\admin\controller\member;

use app\common\controller\BaseController;
use app\common\service\member\IdeService;
use app\Request;


class Ide extends BaseController
{
    /**
     * @var IdeService
     */
    private $ideService;

    public function initialize()
    {
        parent::initialize();
        $this->ideService = new IdeService();
    }

    /**
     * list
     */
    public function list()
    {
        return success($this->ideService->getAllData());
    }

    /**
     * 修改话题简介
     * @param Request $request
     * @throws \think\Exception
     */
    public function update(Request $request)
    {
        $params = $request->param();
        $id = $params['id'];
        return success($this->ideService->update($id, $params));
    }

    /**
     * 修改话题简介
     * @param Request $request
     * @throws \think\Exception
     */
    public function add(Request $request)
    {
        $params = $request->param();
        return success($this->ideService->insertData($params));
    }

    /**
     * 删除
     * @param Request $request
     */
    public function delete(Request $request)
    {
        return success($this->ideService->delete($request->param('ids/s'), true));
    }

}