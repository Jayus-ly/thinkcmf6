<?php


namespace model;

/**
 * 优惠券
 * Class CouponsModel
 * @package model
 */
class CouponsModel extends BaseModel
{
    protected $table = "cmf_coupons";

    protected $field = ['id', 'classification_id', 'name', 'type', 'used', 'code', 'details', 'is_new', 'create_time', 'update_time', 'delete_time', 'is_hot', 'is_home'];

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