<?php


namespace model;

/**
 * 产品分类
 * Class ProductClassificationModel
 * @package model
 */
class ProductClassificationModel extends BaseModel
{
    protected $table = "cmf_product_classification";

    protected $field = ['id', 'name', 'img_url', 'create_time', 'update_time', 'delete_time'];

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