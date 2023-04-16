<?php

namespace app\common\service;

class BaseService
{
    /**
     * 列表
     * @param array $where
     * @param int $page
     * @param int $limit
     * @param array $order
     * @param string $field
     * @param array $with
     * @param array $append
     * @param array $hidden
     * @return array
     */
    public static function getAllData(array $where = [], int $page = 1, int $limit = 10, array $order = [], string $field = '*', array $with = [], array $visible = [], array $hidden = []): array
    {
        $where[] = array_merge($where, where_delete());
        $model = static::getModel();
        $pk = $model->getPk();
        $group = $pk;
        if (empty($order)) {
            $order = [$group => 'desc'];
        }
        $count = $model->where($where)->group($group)->count();
        $pages = ceil($count / $limit);
        $list = $model->field($field)->where($where)
            ->with($with)
            ->visible($visible)
            ->hidden($hidden)
            ->page($page)->limit($limit)->order($order)->group($group)->select()->toArray();
        return compact('count', 'pages', 'page', 'limit', 'list');
    }

    /**
     * 插入
     * @param $param
     * @return mixed
     */
    public function insertData($param)
    {
        $model = static::getModel();
        $pk = $model->getPk();
        unset($param[$pk]);
        return $model->save($param);
    }

    /**
     * 修改
     * @param $id
     * @param array $param
     * @return mixed
     * @throws \think\Exception
     */
    public static function update($id, array $param = [])
    {
        if (empty($id)) {
            exception('缺少参数');
        }
        $model = static::getModel();
        $pk = $model->getPk();
        unset($param[$pk], $param['id']);
        return $model->where($pk, $id)->update($param);
    }

    public function updateData($filter, $data)
    {
        return static::getModel()->where($filter)->update($data);
    }

    /**
     * @param $ids
     * @param bool $real 是否真删除
     * @return mixed
     */
    public function delete($ids, $real = false)
    {
        $model = static::getModel();
        $pk = $model->getPk();
        if (is_numeric($ids)) {
            $ids = [$ids];
        }
        if ($real) {
           $result = $model->where($pk, 'in', $ids)->delete();
        } else {
            $update = delete_update();
            $result = $model->where($pk, 'in', $ids)->update($update);
        }
        return $result;
    }
}