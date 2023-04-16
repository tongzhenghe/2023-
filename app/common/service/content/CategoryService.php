<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\common\service\content;

use app\common\cache\content\CategoryCache;
use app\common\cache\content\ContentCache;
use app\common\model\content\CategoryModel;
use app\common\model\content\AttributesModel;

/**
 * 内容分类
 */
class CategoryService
{
    /**
     * 添加、修改字段
     * @var array
     */
    public static $edit_field = [
        'category_id/d'     => 0,
        'category_pid/d'    => 0,
        'category_name/s'   => '',
        'category_unique/s' => '',
        'cover_id/d'        => 0,
        'title/s'           => '',
        'keywords/s'        => '',
        'description/s'     => '',
        'sort/d'            => 250,
        'images/a'          => [],
    ];

    /**
     * 内容分类列表
     * 
     * @param string $type  tree树形，list列表
     * @param array  $where 条件
     * @param array  $order 排序
     * @param string $field 字段
     * 
     * @return array
     */
    public static function list($type = 'tree', $where = [], $order = [], $field = '')
    {
        $model = new CategoryModel();
        $pk = $model->getPk();

        if (empty($field)) {
            $field = $pk . ',category_pid,category_name,category_unique,cover_id,sort,is_disable,create_time,update_time';
        }
        if (empty($order)) {
            $order = ['sort' => 'desc', $pk => 'asc'];
        }

        $key = $type . md5(serialize($where) . serialize($order) . $field);
        $data = CategoryCache::get($key);
        if (empty($data)) {
            $model = $model->field($field)->where($where);
            if (strpos($field, 'cover_id')) {
                $model = $model->with(['cover'])->append(['cover_url'])->hidden(['cover']);
            }
            $data = $model->order($order)->select()->toArray();

            if ($type == 'tree') {
                $data = array_to_tree($data, $pk, 'category_pid');
            }

            CategoryCache::set($key, $data);
        }

        return $data;
    }

    /**
     * 内容分类信息
     * 
     * @param int|string $id   分类id、标识
     * @param bool       $exce 不存在是否抛出异常
     * 
     * @return array|Exception
     */
    public static function info($id, $exce = true)
    {
        $info = CategoryCache::get($id);
        if (empty($info)) {
            $model = new CategoryModel();
            $pk = $model->getPk();

            if (is_numeric($id)) {
                $where[] = [$pk, '=', $id];
            } else {
                $where[] = ['category_unique', '=', $id];
                $where[] = where_delete();
            }

            $info = $model->where($where)->find();
            if (empty($info)) {
                if ($exce) {
                    exception('内容分类不存在：' . $id);
                }
                return [];
            }
            $info = $info->append(['cover_url', 'images'])->toArray();

            CategoryCache::set($id, $info);
        }

        return $info;
    }

    /**
     * 内容分类添加
     *
     * @param array $param 分类信息
     *
     * @return array|Exception
     */
    public static function add($param)
    {
        $model = new CategoryModel();
        $pk = $model->getPk();

        unset($param[$pk]);

        $param['create_uid']  = user_id();
        $param['create_time'] = datetime();

        // 启动事务
        $model->startTrans();
        try {
            // 添加
            $model->save($param);
            // 添加图片
            $file_ids = file_ids($param['images']);
            $model->images()->saveAll($file_ids);
            // 提交事务
            $model->commit();
        } catch (\Exception $e) {
            $errmsg = $e->getMessage();
            // 回滚事务
            $model->rollback();
        }

        if (isset($errmsg)) {
            exception($errmsg);
        }

        $param[$pk] = $model->$pk;

        CategoryCache::clear();

        return $param;
    }

    /**
     * 内容分类修改 
     *     
     * @param int|array $ids   分类id
     * @param array     $param 分类信息
     *     
     * @return array|Exception
     */
    public static function edit($ids, $param = [])
    {
        $model = new CategoryModel();
        $pk = $model->getPk();

        unset($param[$pk], $param['ids']);

        $param['update_uid']  = user_id();
        $param['update_time'] = datetime();

        // 启动事务
        $model->startTrans();
        try {
            if (is_numeric($ids)) {
                $ids = [$ids];
            }
            // 修改
            $model->where($pk, 'in', $ids)->update($param);
            if (isset($param['images'])) {
                foreach ($ids as $id) {
                    $info = $model->find($id);
                    // 修改图片
                    if (isset($param['images'])) {
                        $file_ids = file_ids($param['images']);
                        $info->images()->detach();
                        $info->images()->saveAll($file_ids);
                    }
                }
            }
            // 提交事务
            $model->commit();
        } catch (\Exception $e) {
            $errmsg = $e->getMessage();
            // 回滚事务
            $model->rollback();
        }

        if (isset($errmsg)) {
            exception($errmsg);
        }

        $update['ids'] = $ids;

        CategoryCache::clear();

        return $update;
    }

    /**
     * 内容分类删除
     * 
     * @param int|array $ids  分类id
     * @param bool      $real 是否真实删除
     * 
     * @return array|Exception
     */
    public static function dele($ids, $real = false)
    {
        $model = new CategoryModel();
        $pk = $model->getPk();

        // 启动事务
        $model->startTrans();
        try {
            if (is_numeric($ids)) {
                $ids = [$ids];
            }
            if ($real) {
                foreach ($ids as $id) {
                    $info = $model->find($id);
                    // 删除图片
                    $info->images()->detach();
                }
                $model->where($pk, 'in', $ids)->delete();
            } else {
                $update = delete_update();
                $model->where($pk, 'in', $ids)->update($update);
            }
            // 提交事务
            $model->commit();
        } catch (\Exception $e) {
            $errmsg = $e->getMessage();
            // 回滚事务
            $model->rollback();
        }

        if (isset($errmsg)) {
            exception($errmsg);
        }

        $update['ids'] = $ids;

        CategoryCache::clear();

        return $update;
    }

    /**
     * 内容分类内容
     *
     * @param array  $where 条件
     * @param int    $page  页数
     * @param int    $limit 数量
     * @param array  $order 排序
     * @param string $field 字段
     * 
     * @return array 
     */
    public static function content($where = [], $page = 1, $limit = 10,  $order = [], $field = '')
    {
        return ContentService::list($where, $page, $limit, $order, $field);
    }

    /**
     * 内容分类内容解除
     *
     * @param array $category_id 分类id
     * @param array $content_ids 内容id
     *
     * @return int
     */
    public static function contentRemove($category_id, $content_ids = [])
    {
        $where[] = ['category_id', 'in', $category_id];
        if (empty($content_ids)) {
            $content_ids = AttributesModel::where($where)->column('content_id');
        }
        $where[] = ['content_id', 'in', $content_ids];

        $res = AttributesModel::where($where)->delete();

        ContentCache::del($content_ids);

        return $res;
    }
}
