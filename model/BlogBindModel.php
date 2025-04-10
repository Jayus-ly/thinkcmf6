<?php


namespace model;

/**
 * 博客中绑定品牌内容
 * Class ProductModel
 * @package model
 */
class BlogBindModel extends BaseModel
{
    protected $table = "cmf_blog_bind";

    protected $field = ['id', 'title', 'subtitle', 'about', 'classification_id', 'create_time', 'update_time', 'delete_time'];

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