<?php


namespace model;

/**
 * 产品
 * Class ProductModel
 * @package model
 */
class ProductModel extends BaseModel
{
    protected $table = "cmf_product";

    protected $field = ['id', 'name', 'img_url', 'new_price', 'old_price', 'classification_id', 'is_hot', 'create_time', 'update_time', 'delete_time', 'item_classification_id'];

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