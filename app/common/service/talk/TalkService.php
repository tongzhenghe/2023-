<?php

namespace app\common\service\talk;

use app\common\model\talk\TalkModel;
use app\common\service\BaseService;

/**
 * 话题管理
 */
class TalkService extends BaseService
{


    /**
     * @return TalkModel
     */
    public static function getModel(): TalkModel
    {
        return new TalkModel();
    }

    /**
     * 修改话题简介
     * @param $params
     * @return void
     * @throws \think\Exception
     */
    public function updateInfoData($params)
    {
        return $this->update($params['id'], $params);
    }

    /**
     * 内容删除
     * 
     * @param int|array $ids  内容id
     * @param bool      $real 是否真实删除
     * 
     * @return array|Exception
     */
    public static function dele($ids, $real = false)
    {
        $model = new ContentModel();
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
                    // 删除分类
                    $info->categorys()->detach();
                    // 删除标签
                    $info->tags()->detach();
                    // 删除文件
                    $info->files()->detach();
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

        ContentCache::del($ids);

        return $update;
    }

    /**
     * 内容上一条
     *
     * @param int $id   内容id
     * @param int $cate 是否当前分类
     * 
     * @return array 上一条内容
     */
    public static function prev($id, $cate = 0)
    {
        $model = new ContentModel();
        $pk = $model->getPk();

        $where[] = [$pk, '<', $id];
        $where[] = where_delete();
        if ($cate) {
            $content = self::info($id);
            $where[] = ['category_id', '=', $content['category_id']];
        }

        $info = $model->field($pk . ',name')->where($where)->order($pk, 'desc')->find();
        if (empty($info)) {
            return [];
        }
        $info = $info->toArray();

        return $info;
    }

    /**
     * 内容下一条
     *
     * @param int $id   内容id
     * @param int $cate 是否当前分类
     * 
     * @return array 下一条内容
     */
    public static function next($id, $cate = 0)
    {
        $model = new ContentModel();
        $pk = $model->getPk();

        $where[] = [$pk, '>', $id];
        $where[] = where_delete();
        if ($cate) {
            $content = self::info($id);
            $where[] = ['category_id', '=', $content['category_id']];
        }

        $info = $model->field($pk . ',name')->where($where)->order($pk, 'asc')->find();
        if (empty($info)) {
            return [];
        }
        $info = $info->toArray();

        return $info;
    }

    /**
     * 内容统计
     * @Apidoc\Returned("category", type="int", desc="分类总数")
     * @Apidoc\Returned("content", type="int", desc="内容总数")
     * @Apidoc\Returned("x_data", type="array", desc="图表xAxis.data")
     * @Apidoc\Returned("s_data", type="array", desc="图表series.data")
     * @return array
     */
    public static function statistic()
    {
        $key = 'statistic';
        $data = ContentCache::get($key);
        if (empty($data)) {
            $CategoryModel = new CategoryModel();
            $category_count = $CategoryModel->where([where_delete()])->count();

            $ContentModel = new ContentModel();
            $content_count = $ContentModel->where([where_delete()])->count();

            $AttributesModel = new AttributesModel();
            $categorys = $AttributesModel->alias('a')
                ->join('content c', 'a.content_id=c.content_id', 'left')
                ->join('content_category cc', 'a.category_id=cc.category_id', 'left')
                ->field('a.category_id,count(a.category_id) as content_count,cc.category_name')
                ->where('a.category_id', '>', 0)
                ->where('c.is_delete', '=', 0)
                ->order('content_count', 'asc')
                ->group('a.category_id')
                ->select();

            $x_data = $s_data = [];
            foreach ($categorys as $v) {
                $x_data[] = $v['category_name'];
                $s_data[] = $v['content_count'];
            }

            $data['category'] = $category_count;
            $data['content']  = $content_count;
            $data['x_data']   = $x_data;
            $data['s_data']   = $s_data;

            ContentCache::set($key, $data);
        }

        return $data;
    }
}
