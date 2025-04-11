<?php


namespace model;

use think\Exception;

class FreeStuffTagModel extends BaseModel
{
    protected $table = "cmf_free_stuff_tag";

    protected $field = ['id', 'name', 'create_time', 'update_time', 'delete_time'];

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