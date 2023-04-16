<?php

namespace app\admin\controller\talk;

use app\BaseController;
use app\common\service\talk\prefixService;
use app\Request;

/**
 * 前缀
 */
class Prefix extends BaseController
{
    private $prefixService;
    public function initialize()
    {
        parent::initialize();
        $this->prefixService = new prefixService();
    }

    /**
     * list
     */
    public function list()
    {
        return success($this->prefixService->getAll());
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
        return success($this->prefixService->update($id, $params));
    }

   /**
     * 修改话题简介
     * @param Request $request
     * @throws \think\Exception
     */
    public function add(Request $request)
    {
        $params = $request->param();
        return success($this->prefixService->insertData($params));
    }

    /**
     * 删除
     * @param Request $request
     */
    public function delete(Request $request)
    {
        return success($this->prefixService->delete($request->param('ids/s'), true));
    }
}