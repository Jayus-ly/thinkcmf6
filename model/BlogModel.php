<?php


namespace model;

use think\Exception;

/**
 * 博客表
 * Class ProductModel
 * @package model
 */
class BlogModel extends BaseModel
{
    protected $table = "cmf_blog";

    protected $field = ['id', 'title', 'subtitle', 'img_url', 'create_time', 'update_time', 'delete_time', 'about', 'bind_item_classification'];

    // 静态实例
    protected static $instance = null;

    /**
     * 获取模型的单例实例
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * 获取博客详情和绑定的信息
     * @param int $blogId
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getBlogInfo($blogId = 0)
    {
        $model = self::getInstance()
            ->find($blogId)
            ->toArray();

        if (empty($model)) {
            throw new Exception('系统错误');
        }

        $bind_item_classification = explode(',', $model['bind_item_classification']);

        $model['classification_list'] = ItemClassificationModel::getInstance()
            ->whereIn('id', $bind_item_classification)
            ->select()
            ->toArray();

        return $model;
    }
}