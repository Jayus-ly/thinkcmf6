<?php


namespace model;

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
}