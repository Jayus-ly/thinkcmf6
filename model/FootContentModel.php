<?php


namespace model;

use think\Exception;

/**
 * 底部内容设置
 * Class ProductModel
 * @package model
 */
class FootContentModel extends BaseModel
{
    protected $table = "cmf_foot_content";

    protected $field = ['id', 'content', 'name', 'create_time', 'update_time', 'delete_time'];

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